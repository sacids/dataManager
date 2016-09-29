<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form Authentication class
 *
 * @package     Xform_comms
 * @category    Library
 * @author      Eric Beda
 * @link        http://sacids.org
 */
//
class XmlElement
{
    var $name;
    var $attributes;
    var $content;
    var $children;
}

class Xform_comm
{

    private $CI;

    private $form_defn;
    private $form_data;
    private $xml_defn_filename;
    private $xml_data_filename;
    private $table_name;
    private $jr_form_id;
    private $xarray;
    private $itext;

    public function __construct()
    {
        $this->CI =& get_instance();
        log_message('debug', 'Xform_comm library initialized');
        $this->itext = array();
    }


    public function load_defn($filename)
    {

    }

    public function load_data($filename)
    {

    }


    /**
     * @param $filename
     */
    public function set_defn_file($filename)
    {
        $this->xml_defn_filename = $filename;
    }

    /**
     * @return mixed
     */
    public function get_defn_file()
    {
        return $this->xml_defn_filename;
    }

    public function get_defn()
    {

        return $this->xarray;
    }

    public function get_structure()
    {

        $str = $this->xarray;
        $holder = array();
        foreach ($str as $key => $val) {

            array_push($holder, $val['field_name']);
        }

        return $holder;
    }

    /**
     * Create an array representative of xform definition file for easy transversing
     * Author : Eric Beda
     */
    public function load_xml_definition($prefix = '')
    {
        $file_name = $this->get_defn_file();
        $xml = file_get_contents($file_name);
        $rxml = $this->xml_to_object($xml);

        // TODO reference by names instead of integer keys
        $instance = $rxml->children [0]->children [1]->children [0]->children [0];


        log_message("debug", "Table prefix during creation " . $prefix);
        $jr_form_id = $instance->attributes ['id'];
        $table_name = $prefix . str_replace("-", "_", $jr_form_id);

        // get array rep of xform
        $this->form_defn = $this->get_form_definition();

        log_message("debug", "Table name " . $table_name);
        $this->table_name = $table_name;
        $this->jr_form_id = $jr_form_id;
    }

    public function load_xml_data($instance_name)
    {

        $xml = file_get_contents($instance_name);
        $rxml = $this->xml_to_object($xml);

        print_r($rxml);
    }


    private function xml_to_object($xml)
    {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $tags);
        xml_parser_free($parser);

        log_message("debug", "Tags => " . json_encode($tags));
        $elements = array(); // the currently filling [child] XmlElement array
        $stack = array();
        foreach ($tags as $tag) {

            $index = count($elements);
            if ($tag ['type'] == "complete" || $tag ['type'] == "open") {
                $elements [$index] = new XmlElement();
                $elements [$index]->name = $tag ['tag'];

                if (!empty ($tag ['attributes'])) {
                    $elements [$index]->attributes = $tag ['attributes'];
                }

                if (!empty ($tag ['value'])) {
                    $elements [$index]->content = $tag ['value'];
                }

                if ($tag ['type'] == "open") { // push
                    $elements [$index]->children = array();
                    $stack [count($stack)] = &$elements;
                    $elements = &$elements [$index]->children;
                }
            }

            if ($tag ['type'] == "close") { // pop
                $elements = &$stack [count($stack) - 1];
                unset ($stack [count($stack) - 1]);
            }
        }

        return $elements [0]; // the single top-level element
    }


    /**
     * Return a double array containing field path as key and a value containing
     * array filled with its corresponding attributes
     * Author : Eric Beda
     *
     * @return array
     */
    private function get_form_definition()
    {

        // retrieve object describing definition file
        $rxml = $this->xml_to_object(file_get_contents($this->get_defn_file()));


        // get the binds compononent of xform
        $binds = $rxml->children [0]->children [1]->children;
        //echo '<pre>'; print_r($rxml->children [1]->children);
        // get the body section of xform
        $tmp2 = $rxml->children [0]->children [1]->children [1]->children [0]->children;

        $tmp3 = $rxml->children [0]->children [1]->children[1]->children;
        //print_r($tmp3);

        $tmp2 = $rxml->children [1]->children;
        // container
        $xarray = array();

        foreach ($tmp3 as $key => $val) {

            $attributes = $val->attributes;
            $lang = $attributes['lang'];
            $this->itext[$lang] = array();
            $this->_iterate_itext($val->children, $lang);
        }

        //print_r($this->itext);

        foreach ($binds as $key => $val) {

            if ($val->name == 'bind') {

                $attributes = $val->attributes;
                $nodeset = $attributes ['nodeset'];

                $xarray [$nodeset] = array();
                $xarray [$nodeset] ['field_name'] = str_replace("/", "_", substr($nodeset, 6));

                // set each attribute key and corresponding value
                foreach ($attributes as $k2 => $v2) {

                    $xarray [$nodeset] [$k2] = $v2;
                }
            }
        }

        $this->xarray = $xarray;
        $this->_iterate_defn_file($tmp2, false);
        return $this->xarray;
    }

    function _iterate_itext($arr, $lang = 'eng')
    {

        $i = 0;
        foreach ($arr as $val) {

            $attributes = $val->attributes;
            $children = $val->children;

            $k = $attributes['id'];
            $v = $children[0]->content;

            $kk = explode(":", $k);
            $k = $kk[0];
            $l = $kk[1];
            $this->itext[$lang][$k][$l] = $v;

        }

    }

    function _iterate_defn_file($arr, $ref = false)
    {

        $i = 0;
        foreach ($arr as $val) {

            switch ($val->name) {

                case 'group':
                    $this->_iterate_defn_file($val->children);
                    break;
                case 'input':
                    $nodeset = $val->attributes['ref'];
                    $this->xarray[$nodeset]['label'] = $this->itext['eng'][$nodeset]['label'];
                    break;
                case 'select':
                case 'select1':
                    $nodeset = $val->attributes['ref'];
                    $this->xarray[$nodeset]['label'] = $this->itext['eng'][$nodeset]['label'];
                    $this->_iterate_defn_file($val->children, $nodeset);
                    break;
                case 'item';
                    $v = $val->children[1]->content;
                    $opt = 'option' . $i++;
                    $l = $this->itext['eng'][$ref][$opt];
                    $this->xarray[$ref]['option'][$v] = $l;
                    break;
            }
        }

    }

    /*
     *
     */


}

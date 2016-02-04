<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 *XForm  Class
 *
 * @package     XForm
 * @category    Controller
 * @author      Eric Beda
 * @link        http://sacids.org
 */

class XmlElement {
    var $name;
    var $attributes;
    var $content;
    var $children;
};

class Xform extends CI_Controller {
    
    
    public function __construct(){
        parent::__construct();
        $this->load->model(array('xform_model','users_model'));
        $this->load->library('form_auth');
        log_message('debug', 'Xform controller initialized');

    }
    
    public function set_xml($filename){
        
        $this->file_name = $filename;
        
    }
    
    public function get_xml(){
        
        return $this->file_name;
    }
    
    
    
 /**
     * XML submission function
     * Author : Renfrid 
     * @param  string  $str    Input string
     * @return response
     */

    public function submission(){
        //Form Received in openrosa server
        $response=201;

        // Get the digest from the http header
        $digest = $_SERVER['PHP_AUTH_DIGEST'];

        //server realm and unique id
        $realm = 'Authorized users of Sacids Openrosa';
        $nonce = md5(uniqid());

        // If there was no digest, show login
        if (empty($digest)):

            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm,$nonce);
            exit;
        endif;

        //http_digest_parse
        $digest_parts = $this->form_auth->http_digest_parse($digest);

        //username from http digest obtained
        $valid_user = $digest_parts['username'];

        //get user details from database
        $user=$this->users_model->get_user_details($valid_user);
        $valid_pass = $user->digest_password; //digest password
        $user_id = $user->id; //user_id
        $db_user = $user->username; //username

        //show status header if user not available in database
        if(empty($db_user)):
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm,$nonce);
            exit;
        endif;


        // Based on all the info we gathered we can figure out what the response should be
        $A1 = $valid_pass; //digest password
        $A2 = md5("{$_SERVER['REQUEST_METHOD']}:{$digest_parts['uri']}");
        $valid_response = md5("{$A1}:{$digest_parts['nonce']}:{$digest_parts['nc']}:{$digest_parts['cnonce']}:{$digest_parts['qop']}:{$A2}");

        // If digest fails, show login
        if ($digest_parts['response']!=$valid_response):
            //populate login form if no digest authenticate
            $this->form_auth->require_login_prompt($realm,$nonce);
            exit;
        endif;



        //IF passes authentication
        if( $_SERVER['REQUEST_METHOD']==="HEAD"):
            $response=204;

        elseif($_SERVER['REQUEST_METHOD']==="POST"):

            foreach( $_FILES as $file):
                //File details
                $file_name=$file['name'];

                //check file extension
                $file_extension=end(explode('.', $file_name));

                if($file_extension == 'xml'):
                    //path to store xml
                    $path=FCPATH."assets/forms/data/xml/".$file_name;

                    //insert form details in database
                    $data=array('file_name' => $file_name, 'user_id' => $user_id);
                    $this->db->insert('submission_form',$data);

                elseif($file_extension == 'jpg' OR $file_extension == 'jpeg' OR $file_extension == 'png'):
                    //path to store images 
                    $path=FCPATH."assets/forms/data/images/".$file_name;

                elseif($file_extension == '3gpp' OR $file_extension == 'amr'):
                    //path to store audio  
                    $path=FCPATH."assets/forms/data/audio/".$file_name;                  

                elseif($file_extension == '3gp' OR $file_extension == 'mp4'):
                    //path to store video
                    $path=FCPATH."assets/forms/data/video/".$file_name;

                endif;

                //upload file to the server
                move_uploaded_file($file['tmp_name'], $path);

            endforeach;

            //call function to insert xform data in a database
            $this->insert($user_id);

        endif;

        //return response
        $this->get_response($response);
    }
    
    
    public function insert($user_id){
        //submission form details
        $query=$this->db->get_where('submission_form',array('user_id' => $user_id,'status' => 0))->row();
        $file_name=$query->file_name;
        
        //call forms
        $this->set_xml(FCPATH."assets/forms/data/xml/".$file_name);
        $this->load_xml_data(); 
        $this->insert_into_table();
        
        echo $this->xform_model->insert_data($statement);
        
    }
    
    public function initialise($file_name){
        
        // create table structure
        $this->set_xml(FCPATH."assets/forms/definition/".$file_name);
        $this->load_xml_definition();
                
        $statement = $this->create_structure();
        $this->load->model('xform_model');
        echo $this->xform_model->create_table($statement);
        
    }
    
    private function load_xml_data(){
        
        $file_name  = $this->get_xml();
        $xml        = file_get_contents($file_name);
        $rxml       = $this->xml_to_object($xml);

        // array to hold values and field names;
        $this->darray       = array();
        $this->table_name   = $rxml->attributes['id'];
        foreach($rxml->children as $val){       
            $this->get_path('',$val);   
        }
    }
    
    private function get_path($name,$obj){
    
        $name .= "_".$obj->name;
        if(is_array($obj->children)){
            foreach($obj->children as $val){
                $this->get_path($name,$val);
            }
        }else{
            $this->darray[substr($name,1)] = $obj->content;
        }
    }
    
    
    private function insert_into_table(){

        $field_names    = "(`".implode("`,`",array_keys($this->darray))."`)";
        $field_values   = "('".implode("','",array_values($this->darray))."')";
        $table_name     = $this->table_name;
        
        $query          = "INSERT INTO $table_name $field_names VALUES $field_values";
        
        echo $query;
    
    }
    
    
    
    private function load_xml_definition(){
        
        $file_name  = $this->get_xml();     
        $xml        = file_get_contents($file_name);
        $rxml       = $this->xml_to_object($xml);
        
        echo '<pre>';
        
        $instance   = $rxml->children[0]->children[1]->children[0]->children[0];
        $table_name = str_replace("-","_",$instance->attributes['id']);
        
        // get array rep of xform
        $this->binds = $this->get_binds();
        
        //print_r($this->binds);
        $this->table_name = $table_name;
    
    }
    

    private function create_structure(){
        
        $structure  = $this->binds;
        $tbl_name   = $this->table_name;
        
        $statement  = "CREATE TABLE $tbl_name ( id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY ";
        foreach($structure as $key => $val){
            
            // check type
            if(empty($val['type'])) continue;
            
            $type       = $val['type'];
            $field_name = $val['field_name'];
            
            if(!empty($val['required'])){
                $required = 'NOT NULL';
            }
            else{
                $required   = '';
            }
            
            if($type == 'string' || $type == 'binary'){         
                $statement  .= ", $field_name VARCHAR(150) $required";
            }
            
            if($type == 'select1'){             
                $statement  .= ", $field_name ENUM('".implode("','",$val['option'])."') $required";             
            }           
            if($type == 'select' || $type == 'text'){
                $statement  .= ", $field_name TEXT $required ";
            }           
            if($type == 'date'){
                $statement  .= ", $field_name DATE $required ";
            }           
            if($type == 'int'){
                $statement  .= ", $field_name INT(20) $required ";
            }
            
            if($type == 'geopoint'){
                
                //echo 'somji';
            }

            $statement .= "\n";
        }
        
        $statement  .= ")";
        
    
        
        
        return $statement;
        
    }
    
    
    
    
    
    private function get_binds(){
    
        $rxml       = $this->xml_to_object(file_get_contents($this->get_xml()));
        $tmp1       = $rxml->children[0]->children[1]->children;
        $tmp2       = $rxml->children[0]->children[1]->children[1]->children[0]->children;
        
        $xarray     = array();
                
        foreach($tmp1 as $key => $val){
            
            if($val->name == 'bind'){
                
                $attributes     = $val->attributes;
                $nodeset        = $attributes['nodeset'];
                
                $xarray[$nodeset]   = array();
                $xarray[$nodeset]['field_name'] = str_replace("/","_",substr($nodeset,6));
                
                foreach($attributes as $k2 => $v2){
                    
                    $xarray[$nodeset][$k2]  = $v2;
                }
            }       
        }
        
        foreach($tmp2 as $val){
            
            $att        = $val->attributes['id'];
            $id         = explode(":",$att);
            $nodeset    = $id[0];
            $label      = $id[1];
            $detail     = $val->children[0]->content;

            // if its an option for select/select1
            if(substr($label,0,6) == 'option'){
                $xarray[$nodeset]['option'][substr($label,6)]   = $detail;
            }else{          
                $xarray[$nodeset][$label]   = $detail;
            }       
        }
        
        
        return $xarray; 
    }
    
    
    
    
    
    private function xml_to_object($xml) {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $tags);
        xml_parser_free($parser);
    
        $elements = array();  // the currently filling [child] XmlElement array
        $stack = array();
        foreach ($tags as $tag) {
            
            $index = count($elements);
            if ($tag['type'] == "complete" || $tag['type'] == "open") {
                $elements[$index] = new XmlElement;
                $elements[$index]->name = $tag['tag'];
                if(!empty($tag['attributes'])) $elements[$index]->attributes = $tag['attributes'];
                if(!empty($tag['value'])) $elements[$index]->content = $tag['value'];
                if ($tag['type'] == "open") {  // push
                    $elements[$index]->children = array();
                    $stack[count($stack)] = &$elements;
                    $elements = &$elements[$index]->children;
                }
            }
            if ($tag['type'] == "close") {  // pop
                $elements = &$stack[count($stack) - 1];
                unset($stack[count($stack) - 1]);
            }
        }
        return $elements[0];  // the single top-level element
    }



        /**
     *  Header Response
     *
     * @param  string $responce_code Input string
     * @param  string $file_path Input string
     * @return response
     */
    function get_response($response){
        //OpenRosa Success Response
        $text_response ='<OpenRosaResponse xmlns="http://openrosa.org/http/response">
                            <message nature="submit_success">Thanks</message>
                          </OpenRosaResponse>';

        $content_length=sizeof($text_response);
        //set header response
        header( "X-OpenRosa-Version: 1.0");
        header( "X-OpenRosa-Accept-Content-Length:".$content_length);
        header( "Date: ".date('r'), false, $response);

        //echo response text
        echo $text_response;
    }
    

    
    
}


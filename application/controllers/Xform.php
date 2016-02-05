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
    

	var $form_defn; 
	var $form_data;
	var $xml_defn;
	var $xml_data;
	var $table_name;
	
	
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('xform_model','users_model'));
        $this->load->library('form_auth');
        log_message('debug', 'Xform controller initialized');

    }
    
    
	public function set_defn_file($filename)
	{		
		$this->xml_defn	= $filename;
	}
	
	public function get_defn_file()
	{		
		return $this->xml_defn;
	}
	
	public function set_data_file($filename)
	{
		$this->xml_data	= $filename;
	}
	
	public function get_data_file()
	{
		return $this->xml_data;
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
   /**
    * inserts xform into database table
    * Author : Eric Beda
    * 
    * @param int 	$user_id // sender user id
    */ 
    
    public function insert($user_id)
    {
        //submission form details
        $query=$this->db->get_where('submission_form',array('user_id' => $user_id,'status' => 0))->row();
        $file_name=$query->file_name;
        
        //call forms
        $this->set_data_file(FCPATH."assets/forms/data/xml/".$file_name);
        $this->load_xml_data();
        $statement		= $this->data_insert_query();
        //$this->load->model('xform_model');
        
        echo $this->xform_model->insert_data($statement);
        
    }
    
    
    /**
     * Creates appropriate tables from an xform definition file
     * Author : Eric Beda
     * 
     * @param string $file_name		xform definition file
     */
    public function initialise($file_name)
    {      
        // create table structure        
        $this->set_defn_file(FCPATH."assets/forms/definition/".$file_name);
        $this->load_xml_definition();
        
        $statement = $this->create_structure();
        //$this->load->model('xform_model');
        echo $this->xform_model->create_table($statement);       
    }
    /**
     * sets form_data variable to an array containing all fields of a filled xform file submitted
     * Author : Eric Beda
     * 
     */
    private function load_xml_data()
    {
        
    	// get submitted file
    	$file_name	= $this->get_data_file();
    	
    	// load file into a string
		$xml		= file_get_contents($file_name);
		
		// convert string into an object
		$rxml		= $this->xml_to_object($xml);		

		// array to hold values and field names;
		$this->form_data	= array();
		$this->table_name	= str_replace("-","_",$rxml->attributes['id']);
		
		// loop through object
		foreach($rxml->children as $val)
		{		
			$this->get_path('',$val);	
		}
    }
    /**
     * Recursive function that runs through xml xform object and uses array keys as 
     * absolute path of variable, and sets its value to the data submitted by user
     * Author : Eric Beda
     * 
     * @param string	$name 		name of xml element
     * @param object	$obj		xml element 
     */
    private function get_path($name,$obj)
    {
    
    	$name .= "_".$obj->name;
		if(is_array($obj->children))
		{
			foreach($obj->children as $val)
			{
				$this->get_path($name,$val);
			}
		}
		else
		{
			$this->form_data[substr($name,1)] = $obj->content;
		}
    }
    
    /**
     * Create query string for inserting data into table from submitted xform data
     * file
     * Author : Eric Beda
     * 
     * @return boolean|string
     */
    private function data_insert_query()
    {

       	$table_name		= $this->table_name;		 
		$form_data		= $this->form_data;
		
		// check to see if their was a point (spatial) field in table definition
		if($field_name	= $this->xform_model->get_point_field($table_name))
		{
			
			// spatial field detected
			// extract spatial field components 
			$geopoints	= explode(" ",$form_data[$field_name]);
			$lat		= $geopoints[0];
			$lon		= $geopoints[1];
			$acc		= $geopoints[3];
			$alt		= $geopoints[2];		
			$point		= "GeomFromText('POINT($lat $lon)')";
				
			// build up query field names for spatial data
			$fn			=  '`'.$field_name.'_lat`,`';
			$fn			.= $field_name.'_lon`,`';
			$fn			.= $field_name.'_acc`,`';
			$fn			.= $field_name.'_alt`,`';
			$fn			.= $field_name.'_point`';

			// build up query data values for spatial data
			$fd			= "'".$lat."',";
			$fd			.= "'".$lon."',";
			$fd			.= "'".$acc."',";
			$fd			.= "'".$alt."',";
			$fd			.= $point;
		
		}else{
			// TO DO, error logging
			echo 'error getting point field';
				return false;
		}
		
		$field_names	= "(`".implode("`,`",array_keys($this->form_data))."`,$fn)";
		$field_values	= "('".implode("','",array_values($this->form_data))."',$fd)";
		
		$query			= "INSERT INTO $table_name $field_names VALUES $field_values";	
		return $query; 
    }
    
    
    /**
     * Create an array representative of xform definition file for easy transversing
     * Author : Eric Beda
     * 
     */
    private function load_xml_definition()
    {
        
       	$file_name	= $this->get_defn_file();
		$xml		= file_get_contents($file_name);
		$rxml		= $this->xml_to_object($xml);
		
		$instance	= $rxml->children[0]->children[1]->children[0]->children[0];
		$table_name	= str_replace("-","_",$instance->attributes['id']);
		
		// get array rep of xform
		$this->form_defn		= $this->get_form_definition();
		
		//print_r($this->binds);
		$this->table_name	= $table_name;
    
    }
    

    /**
     * creates query corresponding to mysql table structure of an xform definition file 
     * Author : Eric Beda
     * 
     * @return string	mysql statement for creating table structure of xform
     */
    private function create_structure()
    {
        
        $structure	= $this->form_defn;
		$tbl_name	= $this->table_name;
		
		// initiate statement, set id as primary key, autoincrement
		$statement	= "CREATE TABLE $tbl_name ( id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY ";
		
		// loop through xform definition array
		foreach($structure as $key => $val)
		{
			
			// check if type is empty
			if(empty($val['type'])) continue;
			
			$type		= $val['type'];
			$field_name	= $val['field_name'];			
			
			// check if field is required
			if(!empty($val['required']))
			{
				$required = 'NOT NULL';
			}
			else{
				$required	= '';
			}
			
			if($type == 'string' || $type == 'binary')
			{			
				$statement	.= ", $field_name VARCHAR(150) $required";
			}
			
			if($type == 'select1')
			{				
				$statement	.= ", $field_name ENUM('".implode("','",$val['option'])."') $required";				
			}			
			
			if($type == 'select' || $type == 'text')
			{
				$statement 	.= ", $field_name TEXT $required ";
			}			
			
			if($type == 'date')
			{
				$statement	.= ", $field_name DATE $required ";
			}			
			
			if($type == 'int')
			{
				$statement 	.= ", $field_name INT(20) $required ";
			}
			
			if($type == 'geopoint')
			{

				$statement 	.= ",".$field_name." VARCHAR(150) $required ";
				$statement 	.= ",".$field_name."_point POINT $required ";
				$statement 	.= ",".$field_name."_lat DECIMAL(38,10) $required ";
				$statement 	.= ",".$field_name."_lng DECIMAL(38,10) $required ";
				$statement 	.= ",".$field_name."_acc DECIMAL(38,10) $required ";
				$statement 	.= ",".$field_name."_alt DECIMAL(38,10) $required ";
			}
				
				$statement .= "\n";
		}
				
		$statement	.= ")";
				
		return $statement;
        
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
		$rxml		= $this->xml_to_object(file_get_contents($this->get_defn_file()));
		
		// get the binds compononent of xform
		$binds		= $rxml->children[0]->children[1]->children;
		
		// get the  body section of xform
		$tmp2		= $rxml->children[0]->children[1]->children[1]->children[0]->children;	
		
		// container
		$xarray		= array();
				
		foreach($binds as $key => $val)
		{
			
			if($val->name == 'bind')
			{
				
				$attributes		= $val->attributes;
				$nodeset		= $attributes['nodeset'];
				
				$xarray[$nodeset]	= array();
				$xarray[$nodeset]['field_name']	= str_replace("/","_",substr($nodeset,6));
				
				// set each attribute key and corresponding value
				foreach($attributes as $k2 => $v2)
				{
					
					$xarray[$nodeset][$k2]	= $v2;
				}
			}		
		}
		
		foreach($tmp2 as $val)
		{
			
			$att		= $val->attributes['id'];
			$id			= explode(":",$att);
			$nodeset	= $id[0];
			$label		= $id[1];
			$detail		= $val->children[0]->content;

			// if its an option for select/select1
			if(substr($label,0,6) == 'option')
			{
				$xarray[$nodeset]['option'][substr($label,6)]	= $detail;
			}else
			{			
				$xarray[$nodeset][$label]	= $detail;
			}		
		}	
		return $xarray;	
	}
    
    
    
    
    
    private function xml_to_object($xml)
    {
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $tags);
        xml_parser_free($parser);
    
        $elements = array();  // the currently filling [child] XmlElement array
        $stack = array();
        foreach ($tags as $tag)
        {
            
            $index = count($elements);
            if ($tag['type'] == "complete" || $tag['type'] == "open")
            {
                $elements[$index] = new XmlElement;
                $elements[$index]->name = $tag['tag'];
                
                if(!empty($tag['attributes']))
                {
                	$elements[$index]->attributes = $tag['attributes'];
                }
                
                if(!empty($tag['value']))
                {
                	$elements[$index]->content = $tag['value'];
                }
                
                if ($tag['type'] == "open") 
                {  // push
                    $elements[$index]->children = array();
                    $stack[count($stack)] = &$elements;
                    $elements = &$elements[$index]->children;
                }
            }
            
            if ($tag['type'] == "close") 
            {  // pop
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


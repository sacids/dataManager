<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/22/2016
 * Time: 1:02 PM
 */


$config['realm'] = "Authorized users of Sacids Openrosa";
$config['Mailchimp_api_key'] = 'ce5f4fc22248789b5c9d141dd166e272-us17';


//Table names
$config['table_xform']              = "xforms";
$config['table_archive_xform']      = "archive_xforms";
$config['table_form_submission']    = "submission_form";
$config['table_feedback']           = "feedback";
$config['table_users']              = "users";

//OHKR Tables
$config['table_species']            = "ohkr_species";
$config['table_diseases']           = "ohkr_diseases";
$config['table_symptoms']           = "ohkr_symptoms";
$config['table_diseases_symptoms']  = "diseases_symptoms";


// Form uploads and Media files
$config['form_definition_upload_dir']   = FCPATH. "assets/forms/definition/";
$config['form_definition_archive_dir']  = FCPATH. "assets/forms/definition/archive/";
$config['form_data_upload_dir']         = FCPATH. "assets/forms/data/xml/";
$config['images_data_upload_dir']       = FCPATH. "assets/forms/data/images/";
$config['audio_data_upload_dir']        = FCPATH. "assets/forms/data/audio/";
$config['video_data_upload_dir']        = FCPATH. "assets/forms/data/video/";

$config['xform_tables_prefix']          = "ad_";
// Tables

$config['sms_sender_id']             = "AfyaData";

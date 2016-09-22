<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'Fomu yako haikupita vigezo vyote vya usalama.';

// Login
$lang['login_heading']         = 'Ingia';
$lang['login_subheading']      = 'Tafadhali ingia na anuani ya barua pepe yako au jina la mtumiaji na neno siri hapa chini.';
$lang['login_identity_label']  = 'Barua pepe/Jina la mtumiaji:';
$lang['login_password_label']  = 'Neno siri:';
$lang['login_remember_label']  = 'Nikumbuke:';
$lang['login_submit_btn']      = 'Ingia';
$lang['login_forgot_password'] = 'Umesahau neno lako la siri?';

// Index
$lang['index_heading']           = 'Watumiaji';
$lang['index_subheading']        = 'Chini ni orodha ya watumiaji.';
$lang['index_fname_th']          = 'Jina la Kwanza';
$lang['index_lname_th']          = 'Jina la Mwisho';
$lang['index_email_th']          = 'Barua Pepe';
$lang['index_phone_th']          = 'Namba ya Simu';
$lang['index_created_on_th']     = 'Imetengenezwa';
$lang['index_last_login_th']     = 'Mara ya mwisho kuingia';
$lang['index_groups_th']         = 'Makundi';
$lang['index_status_th']         = 'Hadhi';
$lang['index_action_th']         = 'Tendo';
$lang['index_active_link']       = 'Hai';
$lang['index_inactive_link']     = 'siyo hai';
$lang['index_create_user_link']  = 'Ongeza mtumiji mpya';
$lang['index_create_group_link'] = 'Tengeneza kundi jipya';

// Deactivate User
$lang['deactivate_heading']                  = 'Zuia akaunti';
$lang['deactivate_subheading']               = 'Una uhakika unataka kuizuia akaunti \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Ndiyo:';
$lang['deactivate_confirm_n_label']          = 'Hapana:';
$lang['deactivate_submit_btn']               = 'Kusanya';
$lang['deactivate_validation_confirm_label'] = 'Hakiki';
$lang['deactivate_validation_user_id_label'] = 'ID ya Mtumiaji';

// Create User
$lang['create_user_heading']                           = 'Tengeneza Mtumiaji';
$lang['create_user_subheading']                        = 'Tafadhali ingiza taarifa ya mtumiaji hapa chini.';
$lang['create_user_fname_label']                       = 'Jina la kwanza:';
$lang['create_user_lname_label']                       = 'Jina la mwisho:';
$lang['create_user_company_label']                     = 'Jina la kampuni:';
$lang['create_user_identity_label']                    = 'utambulisho:';
$lang['create_user_email_label']                       = 'Barua pepe:';
$lang['create_user_country_code_label']                = 'Code ya Nchi:';
$lang['create_user_phone_label']                       = 'Simu:';
$lang['create_user_password_label']                    = 'Neno siri:';
$lang['create_user_password_confirm_label']            = 'Hakiki neno siri:';
$lang['create_user_submit_btn']                        = 'Ongeza mtumiaji';
$lang['create_user_validation_fname_label']            = 'Jina la kwanza';
$lang['create_user_validation_lname_label']            = 'Jina la mwisho';
$lang['create_user_validation_identity_label']         = 'Jina la mtumiaji';
$lang['create_user_validation_email_label']            = 'Barua pepe';
$lang['create_user_validation_phone_label']            = 'Simu';
$lang['create_user_validation_company_label']          = 'Jina la kampuni';
$lang['create_user_validation_password_label']         = 'Neno siri';
$lang['create_user_validation_password_confirm_label'] = 'Neno siri la uhakiki';

// Edit User
$lang['edit_user_heading']                           = 'Hariri';
$lang['edit_user_subheading']                        = 'Please enter the user\'s information below.';
$lang['edit_user_fname_label']                       = 'Jina la kwanza:';
$lang['edit_user_lname_label']                       = 'Jina la mwisho:';
$lang['edit_user_company_label']                     = 'Jina la kampuni:';
$lang['edit_user_email_label']                       = 'Barua pepe:';
$lang['edit_user_phone_label']                       = 'Simu:';
$lang['edit_user_password_label']                    = 'Neno siri: (kama tu unabadilisha)';
$lang['edit_user_password_confirm_label']            = 'Hakiki neno siri (kama tu unabadilisha)';
$lang['edit_user_groups_heading']                    = 'Ni mwanachama wa makundi';
$lang['edit_user_submit_btn']                        = 'Hifadhi mtumiaji';
$lang['edit_user_validation_fname_label']            = 'Jina la kwanza';
$lang['edit_user_validation_lname_label']            = 'Jina la mwisho';
$lang['edit_user_validation_email_label']            = 'Barua pepe';
$lang['edit_user_validation_phone_label']            = 'Simu';
$lang['edit_user_validation_company_label']          = 'Jina la kampuni';
$lang['edit_user_validation_groups_label']           = 'Makundi';
$lang['edit_user_validation_password_label']         = 'Neno siri';
$lang['edit_user_validation_password_confirm_label'] = 'Neno siri la uhakiki';

// Create Group
$lang['create_group_title']                  = 'Tengeneza Kundi';
$lang['create_group_heading']                = 'Tengeneza Kundi';
$lang['create_group_subheading']             = 'Tafadhali jaza taarifa za kundi hapa chini.';
$lang['create_group_name_label']             = 'Jina la kundi:';
$lang['create_group_desc_label']             = 'Maelezo:';
$lang['create_group_submit_btn']             = 'Hifadhi Kundi';
$lang['create_group_validation_name_label']  = 'Jina la kundi';
$lang['create_group_validation_desc_label']  = 'Maelezo';

// Edit Group
$lang['edit_group_title']                  = 'Hariri Kundi';
$lang['edit_group_saved']                  = 'Kundi limehifadhiwa';
$lang['edit_group_heading']                = 'Hariri Kundi';
$lang['edit_group_subheading']             = 'Tafadhali ingiza taarifa za kundi hapa chini.';
$lang['edit_group_name_label']             = 'Jina la kundi:';
$lang['edit_group_desc_label']             = 'Maelezo:';
$lang['edit_group_submit_btn']             = 'Hifadhi Kundi';
$lang['edit_group_validation_name_label']  = 'Jina la kundi';
$lang['edit_group_validation_desc_label']  = 'Maelezo';

// Change Password
$lang['change_password_heading']                               = 'Badili neno siri';
$lang['change_password_old_password_label']                    = 'Neno siri zamani:';
$lang['change_password_new_password_label']                    = 'Neno siri jipya (iwe angalau urefu wa herufi %s ):';
$lang['change_password_new_password_confirm_label']            = 'Hakiki neno siri jipya:';
$lang['change_password_submit_btn']                            = 'Badili';
$lang['change_password_validation_old_password_label']         = 'Neno siri zamani';
$lang['change_password_validation_new_password_label']         = 'Neno siri jipya';
$lang['change_password_validation_new_password_confirm_label'] = 'Hakiki neno siri jipya';

// Forgot Password
$lang['forgot_password_heading']                 = 'Umesahau neno siri';
$lang['forgot_password_subheading']              = 'Tafadhali ingiza %s ili tukutumie barua pepe kwa ajili ya kubadili neno siri lako.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Kabidhi';
$lang['forgot_password_validation_email_label']  = 'Anuani barua pepe';
$lang['forgot_password_identity_label']          = 'Utambulisho';
$lang['forgot_password_email_identity_label']    = 'Barua pepe';
$lang['forgot_password_email_not_found']         = 'Hakuna nyaraka za hiyo barua pepe.';

// Reset Password
$lang['reset_password_heading']                               = 'Badili neno siri';
$lang['reset_password_new_password_label']                    = 'Neno siri jipya (iwe angalau urefu wa herufi %s):';
$lang['reset_password_new_password_confirm_label']            = 'Hakiki neno siri jipya:';
$lang['reset_password_submit_btn']                            = 'Badili';
$lang['reset_password_validation_new_password_label']         = 'Neno siri jipya';
$lang['reset_password_validation_new_password_confirm_label'] = 'Hakiki neno siri jipya';

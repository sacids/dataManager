<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Auth Lang - English
 *
 * Author: Ben Edmunds
 *          ben.edmunds@gmail.com
 * @benedmunds
 *
 * Author: Daniel Davis
 * @ourmaninjapan
 *
 * Location: http://github.com/benedmunds/ion_auth/
 *
 * Created:  03.09.2013
 *
 * Description:  English language file for Ion Auth example views
 *
 */

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading'] = 'Connexion';
$lang['login_subheading'] = 'Veuillez vous connecter avec votre adresse e-mail/nom d\'utilisateur et votre mot de passe ci-dessous.';
$lang['login_identity_label'] = 'E-mail/Nom d\'utilisateur :';
$lang['login_password_label'] = 'Mot de passe :';
$lang['login_remember_label'] = 'Se souvenir de moi :';
$lang['login_submit_btn'] = 'Connexion';
$lang['login_forgot_password'] = 'Mot de passe oublié ?';


// Index
$lang['index_heading'] = 'Utilisateurs';
$lang['index_subheading'] = 'Ci-dessous se trouve la liste des utilisateurs.';
$lang['index_name_th'] = 'Nom';
$lang['index_fname_th'] = 'Prénom';
$lang['index_lname_th'] = 'Nom de famille';
$lang['index_email_th'] = 'E-mail';
$lang['index_phone_th'] = 'Téléphone';
$lang['index_created_on_th'] = 'Créé le';
$lang['index_last_login_th'] = 'Dernière connexion';
$lang['index_groups_th'] = 'Groupes';
$lang['index_status_th'] = 'Statut';
$lang['index_action_th'] = 'Action';
$lang['index_active_link'] = 'Actif';
$lang['index_inactive_link'] = 'Inactif';
$lang['index_create_user_link'] = 'Créer un nouvel utilisateur';
$lang['index_create_group_link'] = 'Créer un nouveau groupe';


// Deactivate User
$lang['deactivate_heading'] = 'Désactiver l\'utilisateur';
$lang['deactivate_subheading'] = 'Êtes-vous sûr de vouloir désactiver l\'utilisateur \'%s\' ?';
$lang['deactivate_confirm_y_label'] = 'Oui :';
$lang['deactivate_confirm_n_label'] = 'Non :';
$lang['deactivate_submit_btn'] = 'Soumettre';
$lang['deactivate_validation_confirm_label'] = 'Confirmation';
$lang['deactivate_validation_user_id_label'] = 'Identifiant utilisateur';

// Create User
$lang['create_user_heading'] = 'Créer un utilisateur';
$lang['create_user_subheading'] = 'Veuillez entrer les informations de l\'utilisateur ci-dessous.';
$lang['create_user_fname_label'] = 'Prénom :';
$lang['create_user_lname_label'] = 'Nom de famille :';
$lang['create_user_company_label'] = 'Nom de l\'entreprise :';
$lang['create_user_identity_label'] = 'Identité :';
$lang['create_user_email_label'] = 'E-mail :';
$lang['create_user_country_code_label'] = 'Code pays :';
$lang['create_user_phone_label'] = 'Téléphone :';
$lang['create_user_group_label'] = 'Groupe :';
$lang['create_user_district_label'] = 'District :';
$lang['create_user_password_label'] = 'Mot de passe :';
$lang['create_user_password_confirm_label'] = 'Confirmer le mot de passe :';
$lang['create_user_submit_btn'] = 'Créer un utilisateur';
$lang['create_user_validation_fname_label'] = 'Prénom';
$lang['create_user_validation_lname_label'] = 'Nom de famille';
$lang['create_user_validation_identity_label'] = 'Nom d\'utilisateur';
$lang['create_user_validation_email_label'] = 'Adresse e-mail';
$lang['create_user_validation_phone_label'] = 'Téléphone';
$lang['create_user_validation_group_label'] = 'Groupe';
$lang['create_user_validation_district_label'] = 'District';
$lang['create_user_validation_company_label'] = 'Nom de l\'entreprise';
$lang['create_user_validation_password_label'] = 'Mot de passe';
$lang['create_user_validation_password_confirm_label'] = 'Confirmation du mot de passe';


// Edit User
$lang['edit_user_heading'] = 'Modifier l\'utilisateur';
$lang['edit_user_subheading'] = 'Veuillez entrer les informations de l\'utilisateur ci-dessous.';
$lang['edit_user_fname_label'] = 'Prénom :';
$lang['edit_user_lname_label'] = 'Nom de famille :';
$lang['edit_user_company_label'] = 'Nom de l\'entreprise :';
$lang['edit_user_email_label'] = 'E-mail :';
$lang['edit_user_phone_label'] = 'Téléphone :';
$lang['edit_user_password_label'] = 'Mot de passe : (si vous changez de mot de passe)';
$lang['edit_user_password_confirm_label'] = 'Confirmer le mot de passe : (si vous changez de mot de passe)';
$lang['edit_user_groups_heading'] = 'Membre des groupes';
$lang['edit_user_submit_btn'] = 'Enregistrer l\'utilisateur';
$lang['edit_user_validation_fname_label'] = 'Prénom';
$lang['edit_user_validation_lname_label'] = 'Nom de famille';
$lang['edit_user_validation_email_label'] = 'Adresse e-mail';
$lang['edit_user_validation_phone_label'] = 'Téléphone';
$lang['edit_user_validation_company_label'] = 'Nom de l\'entreprise';
$lang['edit_user_validation_groups_label'] = 'Groupes';
$lang['edit_user_validation_password_label'] = 'Mot de passe';
$lang['edit_user_validation_password_confirm_label'] = 'Confirmation du mot de passe';


// Create Group
$lang['create_group_title'] = 'Créer un groupe';
$lang['create_group_heading'] = 'Créer un groupe';
$lang['create_group_subheading'] = 'Veuillez entrer les informations du groupe ci-dessous.';
$lang['create_group_name_label'] = 'Nom du groupe :';
$lang['create_group_desc_label'] = 'Description :';
$lang['create_group_submit_btn'] = 'Créer un groupe';
$lang['create_group_validation_name_label'] = 'Nom du groupe';
$lang['create_group_validation_desc_label'] = 'Description';


// Edit Group
$lang['edit_group_title'] = 'Modifier le groupe';
$lang['edit_group_saved'] = 'Groupe enregistré';
$lang['edit_group_heading'] = 'Modifier le groupe';
$lang['edit_group_subheading'] = 'Veuillez entrer les informations du groupe ci-dessous.';
$lang['edit_group_name_label'] = 'Nom du groupe :';
$lang['edit_group_desc_label'] = 'Description :';
$lang['edit_group_submit_btn'] = 'Enregistrer le groupe';
$lang['edit_group_validation_name_label'] = 'Nom du groupe';
$lang['edit_group_validation_desc_label'] = 'Description';


// Change Password
$lang['change_password_heading'] = 'Changer le mot de passe';
$lang['change_password_old_password_label'] = 'Ancien mot de passe :';
$lang['change_password_new_password_label'] = 'Nouveau mot de passe (au moins %s caractères) :';
$lang['change_password_new_password_confirm_label'] = 'Confirmer le nouveau mot de passe :';
$lang['change_password_submit_btn'] = 'Changer';
$lang['change_password_validation_old_password_label'] = 'Ancien mot de passe';
$lang['change_password_validation_new_password_label'] = 'Nouveau mot de passe';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirmer le nouveau mot de passe';


// Forgot Password
$lang['forgot_password_heading'] = 'Mot de passe oublié';
$lang['forgot_password_subheading'] = 'Veuillez entrer votre %s pour que nous puissions vous envoyer un e-mail pour réinitialiser votre mot de passe.';
$lang['forgot_password_email_label'] = '%s :';
$lang['forgot_password_submit_btn'] = 'Soumettre';
$lang['forgot_password_validation_email_label'] = 'Adresse e-mail';
$lang['forgot_password_identity_label'] = 'Identité';
$lang['forgot_password_email_identity_label'] = 'E-mail';
$lang['forgot_password_email_not_found'] = 'Aucun enregistrement trouvé pour cette adresse e-mail.';

// Reset Password
$lang['reset_password_heading'] = 'Changer le mot de passe';
$lang['reset_password_new_password_label'] = 'Nouveau mot de passe (au moins %s caractères) :';
$lang['reset_password_new_password_confirm_label'] = 'Confirmer le nouveau mot de passe :';
$lang['reset_password_submit_btn'] = 'Changer';
$lang['reset_password_validation_new_password_label'] = 'Nouveau mot de passe';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirmer le nouveau mot de passe';

$lang['edit_user_assign_permission'] = 'Attribuer une autorisation';

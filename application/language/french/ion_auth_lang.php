<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
*         ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Création de compte
$lang['account_creation_successful']            = 'Compte créé avec succès';
$lang['account_creation_unsuccessful']          = 'Impossible de créer le compte';
$lang['account_creation_duplicate_email']       = 'Adresse e-mail déjà utilisée ou non valide';
$lang['account_creation_duplicate_identity']    = 'Identité déjà utilisée ou non valide';
$lang['account_creation_missing_default_group'] = 'Le groupe par défaut n\'est pas défini';
$lang['account_creation_invalid_default_group'] = 'Nom du groupe par défaut invalide';

// Mot de passe
$lang['password_change_successful']          = 'Mot de passe changé avec succès';
$lang['password_change_unsuccessful']        = 'Impossible de changer le mot de passe';
$lang['forgot_password_successful']          = 'E-mail de réinitialisation de mot de passe envoyé';
$lang['forgot_password_unsuccessful']        = 'Impossible de réinitialiser le mot de passe';

// Activation
$lang['activate_successful']                 = 'Compte activé';
$lang['activate_unsuccessful']               = 'Impossible d\'activer le compte';
$lang['deactivate_successful']               = 'Compte désactivé';
$lang['deactivate_unsuccessful']             = 'Impossible de désactiver le compte';
$lang['activation_email_successful']         = 'E-mail d\'activation envoyé';
$lang['activation_email_unsuccessful']       = 'Impossible d\'envoyer l\'e-mail d\'activation';

// Connexion / Déconnexion
$lang['login_successful']                    = 'Connexion réussie';
$lang['login_unsuccessful']                  = 'Identifiant incorrect';
$lang['login_unsuccessful_not_active']       = 'Le compte est inactif';
$lang['login_timeout']                       = 'Bloqué temporairement. Réessayez plus tard.';
$lang['logout_successful']                   = 'Déconnexion réussie';

// Changements de compte
$lang['update_successful']                   = 'Informations du compte mises à jour avec succès';
$lang['update_unsuccessful']                 = 'Impossible de mettre à jour les informations du compte';
$lang['delete_successful']                   = 'Utilisateur supprimé';
$lang['delete_unsuccessful']                 = 'Impossible de supprimer l\'utilisateur';

// Groupes
$lang['group_creation_successful']           = 'Groupe créé avec succès';
$lang['group_already_exists']                = 'Nom de groupe déjà pris';
$lang['group_update_successful']             = 'Détails du groupe mis à jour';
$lang['group_delete_successful']             = 'Groupe supprimé';
$lang['group_delete_unsuccessful']           = 'Impossible de supprimer le groupe';
$lang['group_delete_notallowed']             = 'Impossible de supprimer le groupe des administrateurs';
$lang['group_name_required']                 = 'Le nom du groupe est un champ obligatoire';
$lang['group_name_admin_not_alter']          = 'Le nom du groupe admin ne peut pas être modifié';

// E-mail d'activation
$lang['email_activation_subject']            = 'Activation du compte';
$lang['email_activate_heading']              = 'Activer le compte pour %s';
$lang['email_activate_subheading']           = 'Veuillez cliquer sur ce lien pour %s.';
$lang['email_activate_link']                 = 'Activer votre compte';

// E-mail de réinitialisation de mot de passe
$lang['email_forgotten_password_subject']    = 'Vérification de mot de passe oublié';
$lang['email_forgot_password_heading']       = 'Réinitialiser le mot de passe pour %s';
$lang['email_forgot_password_subheading']    = 'Veuillez cliquer sur ce lien pour %s.';
$lang['email_forgot_password_link']          = 'Réinitialiser votre mot de passe';

// E-mail de nouveau mot de passe
$lang['email_new_password_subject']          = 'Nouveau mot de passe';
$lang['email_new_password_heading']          = 'Nouveau mot de passe pour %s';
$lang['email_new_password_subheading']       = 'Votre mot de passe a été réinitialisé à : %s';

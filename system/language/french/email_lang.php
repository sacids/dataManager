<?php

defined('BASEPATH') OR exit('Aucun accès direct au script n\'est autorisé.');

$lang['email_must_be_array'] = 'La méthode de validation d\'adresse e-mail doit recevoir un tableau.';
$lang['email_invalid_address'] = 'Adresse e-mail invalide : %s';
$lang['email_attachment_missing'] = 'Impossible de localiser la pièce jointe suivante de l\'e-mail : %s';
$lang['email_attachment_unreadable'] = 'Impossible d\'ouvrir cette pièce jointe : %s';
$lang['email_no_from'] = 'Impossible d\'envoyer un e-mail sans en-tête "De".';
$lang['email_no_recipients'] = 'Vous devez inclure des destinataires : À, Cc ou Cci';
$lang['email_send_failure_phpmail'] = 'Impossible d\'envoyer un e-mail via mail() PHP. Votre serveur pourrait ne pas être configuré pour envoyer des e-mails avec cette méthode.';
$lang['email_send_failure_sendmail'] = 'Impossible d\'envoyer un e-mail via Sendmail PHP. Votre serveur pourrait ne pas être configuré pour envoyer des e-mails avec cette méthode.';
$lang['email_send_failure_smtp'] = 'Impossible d\'envoyer un e-mail via SMTP PHP. Votre serveur pourrait ne pas être configuré pour envoyer des e-mails avec cette méthode.';
$lang['email_sent'] = 'Votre message a été envoyé avec succès en utilisant le protocole suivant : %s';
$lang['email_no_socket'] = 'Impossible d\'ouvrir une socket vers Sendmail. Veuillez vérifier les paramètres.';
$lang['email_no_hostname'] = 'Vous n\'avez pas spécifié de nom d\'hôte SMTP.';
$lang['email_smtp_error'] = 'L\'erreur SMTP suivante a été rencontrée : %s';
$lang['email_no_smtp_unpw'] = 'Erreur : Vous devez attribuer un nom d\'utilisateur et un mot de passe SMTP.';
$lang['email_failed_smtp_login'] = 'Échec de la commande AUTH LOGIN. Erreur : %s';
$lang['email_smtp_auth_un'] = 'Échec de l\'authentification du nom d\'utilisateur. Erreur : %s';
$lang['email_smtp_auth_pw'] = 'Échec de l\'authentification du mot de passe. Erreur : %s';
$lang['email_smtp_data_failure'] = 'Impossible d\'envoyer les données : %s';
$lang['email_exit_status'] = 'Code de statut de sortie : %s';

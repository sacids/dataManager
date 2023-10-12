<?php

defined('BASEPATH') OR exit('Aucun accès direct au script n\'est autorisé.');

$lang['db_invalid_connection_str'] = 'Impossible de déterminer les paramètres de la base de données en fonction de la chaîne de connexion que vous avez soumise.';
$lang['db_unable_to_connect'] = 'Impossible de se connecter à votre serveur de base de données en utilisant les paramètres fournis.';
$lang['db_unable_to_select'] = 'Impossible de sélectionner la base de données spécifiée : %s';
$lang['db_unable_to_create'] = 'Impossible de créer la base de données spécifiée : %s';
$lang['db_invalid_query'] = 'La requête que vous avez soumise n\'est pas valide.';
$lang['db_must_set_table'] = 'Vous devez définir la table de base de données à utiliser avec votre requête.';
$lang['db_must_use_set'] = 'Vous devez utiliser la méthode "set" pour mettre à jour une entrée.';
$lang['db_must_use_index'] = 'Vous devez spécifier un index à utiliser pour les mises à jour par lot.';
$lang['db_batch_missing_index'] = 'Une ou plusieurs lignes soumises pour une mise à jour par lot ne contiennent pas l\'index spécifié.';
$lang['db_must_use_where'] = 'Les mises à jour ne sont pas autorisées à moins de contenir une clause "where".';
$lang['db_del_must_use_where'] = 'Les suppressions ne sont pas autorisées à moins de contenir une clause "where" ou "like".';
$lang['db_field_param_missing'] = 'Pour récupérer des champs, le nom de la table en tant que paramètre est requis.';
$lang['db_unsupported_function'] = 'Cette fonctionnalité n\'est pas disponible pour la base de données que vous utilisez.';
$lang['db_transaction_failure'] = 'Échec de la transaction : un rollback a été effectué.';
$lang['db_unable_to_drop'] = 'Impossible de supprimer la base de données spécifiée.';
$lang['db_unsupported_feature'] = 'Fonctionnalité non prise en charge de la plateforme de base de données que vous utilisez.';
$lang['db_unsupported_compression'] = 'Le format de compression de fichier que vous avez choisi n\'est pas pris en charge par votre serveur.';
$lang['db_filepath_error'] = 'Impossible d\'écrire les données dans le chemin de fichier que vous avez soumis.';
$lang['db_invalid_cache_path'] = 'Le chemin de cache que vous avez soumis n\'est pas valide ou ne peut pas être écrit.';
$lang['db_table_name_required'] = 'Un nom de table est requis pour cette opération.';
$lang['db_column_name_required'] = 'Un nom de colonne est requis pour cette opération.';
$lang['db_column_definition_required'] = 'Une définition de colonne est requise pour cette opération.';
$lang['db_unable_to_set_charset'] = 'Impossible de définir le jeu de caractères de connexion client : %s';
$lang['db_error_heading'] = 'Une erreur de base de données s\'est produite';

<?php
/**
 * CodeIgniter
 *
 * Un framework de développement d'application open source pour PHP
 *
 * Ce contenu est publié sous la licence MIT (MIT)
 *
 * Droits d'auteur (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * La permission est accordée, gratuitement, à toute personne obtenant une copie
 * de ce logiciel et des fichiers de documentation associés (le "Logiciel"), de traiter
 * dans le Logiciel sans restriction, y compris, sans limitation, les droits
 * à utiliser, copier, modifier, fusionner, publier, distribuer, sous-licencier et/ou vendre
 * des copies du Logiciel, et de permettre aux personnes à qui le Logiciel est
 * fourni de le faire, sous réserve des conditions suivantes :
 *
 * L'avis de droit d'auteur ci-dessus et cet avis de permission doivent être inclus dans
 * toutes les copies ou parties substantielles du Logiciel.
 *
 * LE LOGICIEL EST FOURNI "TEL QUEL", SANS GARANTIE D'AUCUNE SORTE, EXPRESSE OU IMPLICITE,
 * Y COMPRIS, MAIS SANS S'Y LIMITER, LES GARANTIES DE QUALITÉ MARCHANDE,
 * D'ADÉQUATION À UN USAGE PARTICULIER ET D'ABSENCE DE CONTREFAÇON. EN AUCUN CAS,
 * LES AUTEURS OU LES TITULAIRES DE DROITS D'AUTEUR NE SERONT RESPONSABLES DE TOUTE RÉCLAMATION,
 * DOMMAGES OU AUTRE RESPONSABILITÉ, QUE CE SOIT DANS UNE ACTION CONTRACTUELLE,
 * DÉLICTUELLE OU AUTRE, DÉCOULANT DE, HORS DE OU EN RELATION AVEC LE LOGICIEL OU
 * L'UTILISATION OU D'AUTRES TRAITEMENTS DANS LE LOGICIEL.
 *
 * @package	CodeIgniter
 * @author	Équipe de développement EllisLab
 * @copyright	Droit d'auteur (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Droit d'auteur (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	Licence MIT
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('Aucun accès direct au script n\'est autorisé.');

$lang['upload_userfile_not_set'] = 'Impossible de trouver une variable POST appelée userfile.';
$lang['upload_file_exceeds_limit'] = 'Le fichier téléchargé dépasse la taille maximale autorisée dans votre fichier de configuration PHP.';
$lang['upload_file_exceeds_form_limit'] = 'Le fichier téléchargé dépasse la taille maximale autorisée par le formulaire de soumission.';
$lang['upload_file_partial'] = 'Le fichier n\'a été que partiellement téléchargé.';
$lang['upload_no_temp_directory'] = 'Le dossier temporaire est manquant.';
$lang['upload_unable_to_write_file'] = 'Le fichier n\'a pas pu être écrit sur le disque.';
$lang['upload_stopped_by_extension'] = 'Le téléchargement du fichier a été arrêté par une extension.';
$lang['upload_no_file_selected'] = 'Vous n\'avez pas sélectionné de fichier à télécharger.';
$lang['upload_invalid_filetype'] = 'Le type de fichier que vous essayez de télécharger n\'est pas autorisé.';
$lang['upload_invalid_filesize'] = 'Le fichier que vous essayez de télécharger est plus volumineux que la taille autorisée.';
$lang['upload_invalid_dimensions'] = 'L\'image que vous essayez de télécharger ne correspond pas aux dimensions autorisées.';
$lang['upload_destination_error'] = 'Un problème est survenu lors de la tentative de déplacement du fichier téléchargé vers la destination finale.';
$lang['upload_no_filepath'] = 'Le chemin de téléchargement ne semble pas être valide.';
$lang['upload_no_file_types'] = 'Vous n\'avez spécifié aucun type de fichier autorisé.';
$lang['upload_bad_filename'] = 'Le nom de fichier que vous avez soumis existe déjà sur le serveur.';
$lang['upload_not_writable'] = 'Le dossier de destination des téléchargements ne semble pas être accessible en écriture.';

<?php if (!defined('BASEPATH')) exit('Accès direct au script interdit');

/**
 * Créé par PhpStorm.
 * Utilisateur : Godluck Akyoo
 * Date : 2/22/2016
 * Heure : 12:32 PM
 *
 * @Author Godluck Akyoo
 *
 * Description: Fichier de langue française pour les vues Sacids
 *
 */

// Formulaire d'envoi
$lang['heading_form_list'] = 'Formulaires';
$lang['heading_add_new_form'] = 'Ajouter un nouveau formulaire';
$lang['heading_edit_form'] = 'Modifier le formulaire';
$lang['validation_label_form_title'] = 'Titre du formulaire';
$lang['validation_label_form_access'] = 'Accès au formulaire';
$lang['form_upload_successful'] = 'Le formulaire a été enregistré avec succès';
$lang['form_update_successful'] = 'Le formulaire a été mis à jour avec succès';
$lang['form_update_failed'] = 'Impossible de mettre à jour le formulaire';
$lang['form_upload_failed'] = 'Impossible d\'enregistrer le formulaire';
$lang['form_saving_failed'] = 'Échec de l\'enregistrement du formulaire';

$lang['label_form_name'] = "Nom du formulaire";
$lang['label_form_title'] = "Titre du formulaire";
$lang['label_form_id'] = "ID du formulaire";
$lang['label_date_created'] = "Créé le";
$lang['label_description'] = "Description";
$lang['label_cause'] = "Causes";
$lang['label_symptoms'] = "Symptômes courants";
$lang['label_diagnosis'] = "Diagnostic";
$lang['label_treatment'] = "Traitement";
$lang['label_question'] = "Question";
$lang['label_answer'] = "Réponse";
$lang['label_access'] = "Accès";
$lang['label_allow_dhis2'] = "Autoriser l'intégration Dhis2";
$lang['label_xml'] = "Fichier XML";
$lang['label_form_xml_file'] = "Fichier XML du formulaire";
$lang['label_action'] = "Action";

$lang['label_post_title'] = "Titre";
$lang['label_content'] = "Contenu";
$lang['label_status'] = "Statut";

$lang['nav_item_form_list'] = "Formulaires";
$lang['nav_item_form_add_new'] = "Ajouter un nouveau formulaire";

$lang['label_instance_id'] = "ID de l'instance";
$lang['label_message'] = "Message";
$lang['label_user'] = "Utilisateur";
$lang['label_username'] = "Nom d'utilisateur";
$lang['label_feedback_date'] = "Heure";
$lang['label_status'] = "Statut";
$lang['label_data_set'] = "ID de l'ensemble de données Dhis2";
$lang['label_org_unit_id'] = "ID de l'unité d'organisation";
$lang['label_period_type'] = "Type de période"; //par exemple quotidien, hebdomadaire, mensuel
$lang['validation_label_data_set'] = "ID de l'ensemble de données";
$lang['validation_label_org_unit_id'] = "ID de l'unité d'organisation";
$lang['validation_label_period_type'] = "Type de période de déclaration";

// Gestion de formulaire
$lang['form_archived_successful'] = "Le formulaire a été archivé avec succès";
$lang['form_restored_successful'] = "Le formulaire a été restauré depuis les archives avec succès";
$lang['error_failed_to_restore_form'] = "Échec de la restauration du formulaire";
$lang['form_delete_successful'] = "Le formulaire a été supprimé avec succès";
$lang['select_form_to_edit'] = "Vous devez sélectionner un formulaire à modifier";
$lang['select_form_to_delete'] = "Vous devez sélectionner un formulaire à supprimer";
$lang['error_failed_to_delete_form'] = "Échec de la suppression du formulaire";

// Maladie
$lang['label_disease_name'] = "Nom de la maladie";
$lang['label_specie_name'] = "Espèce affectée";
$lang['label_symptom_name'] = "Manifestation clinique";
$lang['label_symptom_code'] = "Code de manifestation clinique";
$lang['label_specie'] = "Espèce";
$lang['label_recipient_group'] = "Groupe pour recevoir des alertes";
$lang['label_alert_message'] = "Message d'alerte";

$lang['select_disease_to_edit'] = "Vous devez sélectionner une maladie à modifier";
$lang['select_disease_to_delete'] = "Vous devez sélectionner une maladie à supprimer";
$lang['select_symptom_to_edit'] = "Vous devez sélectionner une manifestation clinique à modifier";
$lang['select_symptom_to_delete'] = "Vous devez sélectionner une manifestation clinique à supprimer";
$lang['select_specie_to_edit'] = "Vous devez sélectionner une espèce à modifier";
$lang['select_specie_to_delete'] = "Vous devez sélectionner une espèce à supprimer";
$lang['add_disease_successful'] = "La maladie a été ajoutée avec succès";
$lang['add_specie_successful'] = "L'espèce a été ajoutée avec succès";
$lang['add_symptom_successful'] = "La manifestation clinique a été ajoutée avec succès";
$lang['edit_disease_successful'] = "La maladie a été modifiée avec succès";
$lang['edit_specie_successful'] = "L'espèce a été modifiée avec succès";
$lang['edit_symptom_successful'] = "La manifestation clinique a été modifiée avec succès";
$lang['delete_disease_successful'] = "La maladie a été supprimée avec succès";
$lang['delete_specie_successful'] = "L'espèce a été supprimée avec succès";
$lang['delete_symptom_successful'] = "La manifestation clinique a été supprimée avec succès";
$lang['error_failed_to_add_disease'] = "Échec de l'ajout de la nouvelle maladie";
$lang['error_failed_to_add_specie'] = "Échec de l'ajout de la nouvelle espèce";
$lang['error_failed_to_add_symptom'] = "Échec de l'ajout de la manifestation clinique";
$lang['error_failed_to_edit_disease'] = "Échec de la modification de la nouvelle maladie";
$lang['error_failed_to_edit_specie'] = "Échec de la modification de la nouvelle espèce";
$lang['error_failed_to_edit_symptom'] = "Échec de la modification de la nouvelle manifestation clinique";


$lang['select_faq_to_edit'] = "Vous devez sélectionner une FAQ à modifier";
$lang['select_faq_to_delete'] = "Vous devez sélectionner une FAQ à supprimer";
$lang['add_faq_successful'] = "La FAQ a été ajoutée avec succès";
$lang['error_failed_to_add_faq'] = "Échec de l'ajout d'une nouvelle FAQ";
$lang['edit_faq_successful'] = "La FAQ a été modifiée avec succès";
$lang['error_failed_to_edit_faq'] = "Échec de la modification de la FAQ";
$lang['delete_faq_successful'] = "La FAQ";
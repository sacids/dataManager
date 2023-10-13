<?php if (!defined('BASEPATH')) exit('Aucun accès direct au script n\'est autorisé');

/**
 * Créé par : Godluck Akyoo
 * Date : 22 février 2016
 * Heure : 12h32
 *
 * @Author Godluck Akyoo
 *
 * Description : Fichier de langue anglaise pour les vues de Sacids
 *
 */

// Formulaire d'envoi
$lang['heading_form_list'] = 'Formulaires';
$lang['heading_add_new_form'] = 'Ajouter un nouveau formulaire';
$lang['heading_edit_form'] = 'Modifier le formulaire';
$lang['validation_label_form_title'] = 'Titre du formulaire';
$lang['validation_label_form_access'] = 'Accès au formulaire';
$lang['form_upload_successful'] = 'Formulaire enregistré avec succès';
$lang['form_update_successful'] = 'Formulaire mis à jour avec succès';
$lang['form_update_failed'] = 'Échec de la mise à jour du formulaire';
$lang['form_upload_failed'] = 'Échec de l\'enregistrement du formulaire';
$lang['form_saving_failed'] = 'Échec de l\'enregistrement du formulaire';

$lang['label_form_name'] = "Nom du formulaire";
$lang['label_form_title'] = "Titre du formulaire";
$lang['label_form_id'] = "Identifiant du formulaire";
$lang['label_date_created'] = "Créé le";
$lang['label_description'] = "Description";
$lang['label_cause'] = "Causes";
$lang['label_symptoms'] = "Symptômes courants";
$lang['label_diagnosis'] = "Diagnostic";
$lang['label_treatment'] = "Traitement";
$lang['label_question'] = "Question";
$lang['label_answer'] = "Réponse";
$lang['label_access'] = "Accès";
$lang['label_allow_dhis2'] = "Autoriser l'intégration DHIS2";
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
$lang['label_data_set'] = "ID du jeu de données DHIS2";
$lang['label_org_unit_id'] = "ID de l'unité organisationnelle";
$lang['label_period_type'] = "Type de période"; // par exemple, quotidien, hebdomadaire, mensuel
$lang['validation_label_data_set'] = "ID du jeu de données";
$lang['validation_label_org_unit_id'] = "ID de l'unité organisationnelle";
$lang['validation_label_period_type'] = "Type de période de déclaration";

// Gestion de formulaire
$lang['form_archived_successful'] = "Formulaire archivé avec succès";
$lang['form_restored_successful'] = "Formulaire restauré avec succès depuis les archives";
$lang['error_failed_to_restore_form'] = "Échec de la restauration du formulaire";
$lang['form_delete_successful'] = "Formulaire supprimé avec succès";
$lang['select_form_to_edit'] = "Vous devez sélectionner un formulaire à modifier";
$lang['select_form_to_delete'] = "Vous devez sélectionner un formulaire à supprimer";
$lang['error_failed_to_delete_form'] = "Échec de la suppression du formulaire";

// Maladie
$lang['label_disease_name'] = "Nom de la maladie";
$lang['label_specie_name'] = "Espèce affectée";
$lang['label_symptom_name'] = "Manifestation clinique";
$lang['label_symptom_code'] = "Code de manifestation clinique";
$lang['label_specie'] = "Espèces";
$lang['label_recipient_group'] = "Groupe pour recevoir des alertes";
$lang['label_alert_message'] = "Message d'alerte";

$lang['select_disease_to_edit'] = "Vous devez sélectionner une maladie à modifier";
$lang['select_disease_to_delete'] = "Vous devez sélectionner une maladie à supprimer";
$lang['select_symptom_to_edit'] = "Vous devez sélectionner une manifestation clinique à modifier";
$lang['select_symptom_to_delete'] = "Vous devez sélectionner une manifestation clinique à supprimer";
$lang['select_specie_to_edit'] = "Vous devez sélectionner une espèce à modifier";
$lang['select_specie_to_delete'] = "Vous devez sélectionner une espèce à supprimer";
$lang['add_disease_successful'] = "Maladie ajoutée avec succès";
$lang['add_specie_successful'] = "Espèce ajoutée avec succès";
$lang['add_symptom_successful'] = "Manifestation clinique ajoutée avec succès";
$lang['edit_disease_successful'] = "Maladie modifiée avec succès";
$lang['edit_specie_successful'] = "Espèce modifiée avec succès";
$lang['edit_symptom_successful'] = "Manifestation clinique modifiée avec succès";
$lang['delete_disease_successful'] = "Maladie supprimée avec succès";
$lang['delete_specie_successful'] = "Espèce supprimée avec succès";
$lang['delete_symptom_successful'] = "Manifestation clinique supprimée avec succès";
$lang['error_failed_to_add_disease'] = "Échec de l'ajout d'une nouvelle maladie";
$lang['error_failed_to_add_specie'] = "Échec de l'ajout d'une nouvelle espèce";
$lang['error_failed_to_add_symptom'] = "Échec de l'ajout de manifestation clinique";
$lang['error_failed_to_edit_disease'] = "Échec de la modification d'une nouvelle maladie";
$lang['error_failed_to_edit_specie'] = "Échec de la modification d'une nouvelle espèce";
$lang['error_failed_to_edit_symptom'] = "Échec de la modification d'une nouvelle manifestation clinique";

$lang['select_faq_to_edit'] = "Vous devez sélectionner une FAQ à modifier";
$lang['select_faq_to_delete'] = "Vous devez sélectionner une FAQ à supprimer";
$lang['add_faq_successful'] = "FAQ ajoutée avec succès";
$lang['error_failed_to_add_faq'] = "Échec de l'ajout d'une nouvelle FAQ";
$lang['edit_faq_successful'] = "FAQ modifiée avec succès";
$lang['error_failed_to_edit_faq'] = "Échec de la modification de la FAQ";
$lang['delete_faq_successful'] = "FAQ supprimée avec succès";
$lang['error_failed_to_delete_faq'] = "Échec de la suppression de la FAQ";

// Retour d'information
$lang['feedback_received_successful'] = 'Retour d\'information reçu avec succès';
$lang['no_content'] = 'Aucun contenu';
$lang['unknown_error_occurred'] = 'Erreur inconnue';
$lang['user_does_not_exist'] = 'L\'utilisateur n\'existe pas';

// Campagne
$lang['label_campaign_title'] = "Titre";
$lang['label_campaign_type'] = "Type";
$lang['label_campaign_icon'] = "Icône";
$lang['label_campaign_featured'] = "En vedette";
$lang['label_campaign_created_date'] = "Date de création";

// Tableau de bord
$lang['label_read_more'] = "Lire la suite";
$lang['label_detected_disease'] = "Maladies principalement détectées";
$lang['label_user_chats'] = "Chats d'utilisateurs";
$lang['label_graphical_submission'] = "Soumissions récentes sous forme graphique";
$lang['label_recent_user_chats'] = 'Chats d\'utilisateurs récents';
$lang['label_active_campaigns'] = 'Campagnes actives';
$lang['label_published_forms'] = 'Formulaires publics';
$lang['label_data_collectors'] = 'Collecteurs de données';
$lang['label_frequently_detected_disease'] = 'Maladie fréquemment détectée';
$lang['label_conversation'] = "Conversation";
$lang['label_graph_title'] = "Formulaires soumis globalement";
$lang['label_graph_series_name'] = "Formulaires soumis";
$lang['label_form_submitted'] = "Formulaire soumis";
$lang['label_graph_period_overall'] = "Global";
$lang['label_graph_period_monthly'] = "Mensuel";
$lang['label_graph_period_weekly'] = "Hebdomadaire";
$lang['label_graph_period_daily'] = "Quotidien";

/* Module CHR */

$lang['label_chr_first_name'] = 'Prénom';
$lang['label_chr_last_name'] = 'Nom de famille';
$lang['label_chr_email'] = 'Adresse e-mail';
$lang['label_chr_phone'] = 'Numéro de téléphone';
$lang['label_chr_school_college'] = 'École ou collège';
$lang['label_chr_field_study'] = 'Domaine d\'études';
$lang['label_chr_grade'] = 'Grade ou qualification';
$lang['label_chr_activities'] = 'Activités et sociétés';
$lang['label_chr_from_year'] = 'De l\'année';
$lang['label_chr_to_year'] = 'À l\'année (ou prévue)';

$lang['btn_add_chr'] = 'Ajouter un CHR';

/* Bouton */
$lang['button_save'] = 'Enregistrer';
$lang['button_cancel'] = 'Annuler';

/*
 * Module de projet
 */
$lang['title_add_new_project'] = 'Ajouter un nouveau projet';
$lang['title_manage_project'] = 'Gérer les projets';
$lang['label_project_title'] = 'Titre';
$lang['label_project_description'] = 'Description';
$lang['label_project_created_date'] = 'Date de création';
$lang['label_action'] = 'Action';
$lang['label_edit'] = 'Modifier';
$lang['placeholder_project_title'] = 'Entrez le titre du projet';
$lang['placeholder_project_description'] = 'Entrez la description du projet';
$lang['button_add_project'] = 'Enregistrer le projet';
$lang['button_upload_new_form'] = 'Télécharger un nouveau formulaire';

$lang['title_list_projects'] = 'Projets';
$lang['label_select_project_to_list_forms'] = 'Sélectionnez un projet pour voir les formulaires';
$lang['title_project_forms'] = 'Formulaires de projet';

$lang['title_edit_project'] = 'Modifier le projet';
$lang['button_save_changes'] = 'Enregistrer les modifications';

$lang['message_project_added'] = 'Projet ajouté';
$lang['message_project_not_added'] = 'Échec de l\'ajout du projet';
$lang['message_project_updated'] = 'Projet mis à jour';
$lang['message_project_has_no_form'] = 'Ce projet n\'a pas de formulaire';
$lang['status_message_getting_forms'] = 'Récupération des formulaires de projet, veuillez patienter...';

$lang['label_manage_access_permissions'] = 'Gérer les autorisations d\'accès';
$lang['label_map_columns'] = 'Associer les colonnes';
$lang['label_dhis2_configurations'] = 'Configurations DHIS2';
$lang['label_group_permissions'] = 'Autorisations de groupe';
$lang['label_user_permissions'] = "Autorisations d'utilisateur";


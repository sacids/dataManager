<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 26-Aug-16
 * Time: 16:52
 */
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Ajouter une nouvelle réponse SMS pour la maladie</h3>
            </div>

            <!-- Fil d'Ariane -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Tableau de bord</a></li>
                <li><a href="<?= site_url('ohkr/disease_list') ?>">Maladies</a></li>
                <li class="active">Ajouter une nouvelle réponse SMS</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            }
            ?>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?php echo form_open('ohkr/add_new_response_sms/' . $disease_id); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo $this->lang->line("label_recipient_group") ?>
                                <span>* :</span></label>
                            <?php
                            $groupOptions = array("" => "Choisissez un groupe à alerter");
                            foreach ($groups as $group) {
                                $groupOptions[$group->id] = $group->name;
                            }
                            echo form_dropdown("group", $groupOptions, set_value("group"), array("id" => "group", "class" => "form-control"));
                            ?>
                        </div>
                        <div class="error" style="color: #ff2b0d"><?php echo form_error('group'); ?></div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line("label_alert_message") ?> * :</label>
                            <textarea class="form-control" name="message" rows="5" id="message"><?php echo set_value('message'); ?></textarea>
                        </div>
                        <div class="error" style="color: #ff2b0d"><?php echo form_error('message'); ?></div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line("label_status") ?><span>* :</span></label>
                            <?php
                            $statusOptions = array("" => "Choisissez un statut", "Enabled" => "Activé", "Disabled" => "Désactivé");
                            echo form_dropdown("status", $statusOptions, set_value("status"), array("id" => "status", "class" => "form-control"));
                            ?>
                        </div>
                        <div class="error" style="color: #ff2b0d"><?php echo form_error('status'); ?></div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Enregistrer', array('class' => "btn btn-primary")); ?>
                            <?= anchor('ohkr/disease_list', 'Annuler', 'class="btn btn-warning"') ?>
                        </div>
                        <!-- /form-group -->
                        <?= form_close() ?>
                    </div>
                    <!--./col-sm-6 -->
                </div>
                <!-- ./col-sm-12 -->
            </div>
            <!--./row -->
        </div>
    </div>
</div>

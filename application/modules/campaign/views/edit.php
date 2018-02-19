<script type="text/javascript">
    $(document).ready(function () {
        $('#general').click(function () {
            $('#div1').hide('fast');
        });
        $('#form').click(function () {
            $('#div1').show('fast');
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit campaign</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('campaign/lists') ?>">Campaigns</a></li>
                <li class="active">Edit campaign</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>
                    <?= form_open(uri_string(), 'role="form"'); ?>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?= $this->lang->line("label_campaign_title"); ?></label>
                            <?= form_input($name); ?>
                        </div>

                        <div class="form-group">
                            <label><?= $this->lang->line("label_campaign_type"); ?></label>
                            <br/>
                            <?= form_radio(array('name' => 'type', 'value' => 'general', 'checked' => ('general' == $campaign->type) ? TRUE : FALSE, 'id' => 'general')); ?>
                            General Campaign
                            <br/><?= form_radio(array('name' => 'type', 'value' => 'form', 'checked' => ('form' == $campaign->type) ? TRUE : FALSE, 'id' => 'form')); ?>
                            Form Campaign
                        </div>

                        <div id="div1" style="display: none" class="form-group">
                            <label><?= $this->lang->line("label_form_name"); ?></label>
                            <?php
                            $form_options = array();
                            foreach ($form_list as $value) {
                                $form_options[$value->jr_form_id] = $value->title;
                            }
                            $form_options = array('' => 'Choose form') + $form_options;
                            echo form_dropdown('jr_form_id', $form_options, set_value('jr_form_id'), 'class="form-control"'); ?>
                        </div>


                        <div class="form-group">
                            <label><?= $this->lang->line("label_description") ?></label>
                            <?= form_textarea($description); ?>
                        </div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                            <?= anchor('campaign/lists', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


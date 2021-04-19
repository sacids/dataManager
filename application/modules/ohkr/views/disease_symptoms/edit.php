<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit <?php echo $disease->title; ?> Clinical Manifestation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/disease_list') ?>">Diseases</a></li>
                <li><a href="<?= site_url('ohkr/disease_symptoms/' . $disease->id) ?>">Clinical Manifestation</a>
                </li>
                <li class="active">Edit New Clinical Manifestation</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pure-form">
                        <?php if (validation_errors() != "") {
                            echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                        } else if ($this->session->flashdata('message') != "") {
                            echo $this->session->flashdata('message');
                        } ?>

                        <?= form_open(uri_string(), 'role="form"'); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Clinical Manifestation <span style="color: red;">*</span></label>
                                    <?php
                                    $symptoms_options = array();
                                    foreach ($symptoms as $value) {
                                        $symptoms_options[$value->id] = $value->code . '. ' . $value->title;
                                    }
                                    $symptoms_options = array('' => 'Choose Symptoms') + $symptoms_options;
                                    echo form_dropdown('symptom', $symptoms_options, set_value('symptom', $disease_symptom->symptom_id), 'class="form-control"');
                                    ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-12 -->

                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Importance (%) <span style="color: red;">*</span></label>
                                    <?= form_input($importance); ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                    <?= anchor('ohkr/disease_symptoms/' . $disease->id, 'Cancel', 'class="btn btn-warning"') ?>
                                </div> <!-- /form-group -->
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->
                        <?= form_close() ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-sm-12 -->
            </div>
            <!--./row -->
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit <?php echo $disease->d_title; ?> Clinical Manifestation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/disease_list') ?>">Diseases</a></li>
                <li><a href="<?= site_url('ohkr/disease_symptoms_list/' . $disease->id) ?>">Clinical Manifestation</a>
                </li>
                <li class="active">Edit New Clinical Manifestation</li>
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
                            <label>Clinical Manifestation <span style="color: red;">*</span></label>
                            <?php
                            $symptoms_options = array();
                            foreach ($symptoms_list as $value) {
                                $symptoms_options[$value->id] = $value->code . '. ' . $value->title;
                            }
                            $symptoms_options = array('' => 'Choose Symptoms') + $symptoms_options;
                            echo form_dropdown('symptom', $symptoms_options, set_value('symptom', $disease_symptom->symptom_id), 'class="form-control"');
                            ?>
                        </div>

                        <div class="form-group">
                            <label>Importance (%) <span style="color: red;">*</span></label>
                            <?= form_input($importance); ?>
                        </div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                            <?= anchor('ohkr/disease_symptoms_list/' . $disease->id, 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div><!--./col-sm-6 -->
                    <?= form_close() ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>
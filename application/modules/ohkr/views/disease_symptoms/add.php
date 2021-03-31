<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add <?= $disease->title; ?> - Clinical Manifestation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/disease_list') ?>">Diseases</a></li>
                <li><a href="<?= site_url('ohkr/disease_symptoms_list/' . $disease->id) ?>">Clinical Manifestation</a>
                </li>
                <li class="active">Add New Clinical Manifestation</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open(uri_string(), 'role="form"'); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Clinical Manifestation <span style="color: red;">*</span></label>
                                <?php
                                $symptoms_options = array();
                                foreach ($symptoms as $value) {
                                    $symptoms_options[$value->id] = $value->code . '. ' . $value->title;
                                }
                                $symptoms_options = array('' => 'Choose Symptoms') + $symptoms_options;
                                echo form_dropdown('symptom_id', $symptoms_options, set_value('symptom_id'), 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div> <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Species <span style="color: red;">*</span></label><br/>
                                <?php
                     
                                $serial = 1;
                                if (isset($species) && $species) {
                                    foreach ($species as $v) { ?>
                                        <input type="checkbox" name="specie_id[]"
                                               value="<?= $v->id; ?>" <?= set_checkbox('specie_id[]', $v->id); ?>>
                                        <?= $v->title . '<br />';
                                        $serial++;
                                    }
                                } ?>
                                <span class="form-text text-danger"><?= form_error('specie_id[]') ?></span>
                            </div>
                        </div>
                    </div> <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Importance (%) <span style="color: red;">*</span></label>
                                <?= form_input($importance); ?>
                            </div>
                        </div>
                    </div> <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                <?= anchor('ohkr/disease_symptoms_list/' . $disease->id, 'Cancel', 'class="btn btn-warning"') ?>
                            </div> <!-- /form-group -->
                        </div>
                    </div> <!-- /.row -->

                    <?= form_close() ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>
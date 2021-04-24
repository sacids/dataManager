<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $disease->title; ?> - Clinical Manifestation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/disease_list') ?>">Diseases</a></li>
                <li class="active"><?= $disease->title; ?> Clinical Manifestation</li>
            </ol>

            <?php if ($this->session->flashdata('message') != "") {
                echo $this->session->flashdata('message');
            } ?>

            <?php if (perms_role('Ohkr', 'add_disease_symptoms')) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pure-form">
                            <?= form_open(uri_string(), 'role="form"'); ?>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
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
                                        <span class="form-text text-danger"><?= form_error('symptom_id') ?></span>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Species <span style="color: red;">*</span></label><br />
                                        <?php
                                        foreach ($species as $specie) {
                                            $species_options[$specie->id] = $specie->title;
                                        }
                                        echo form_dropdown("specie_id[]", $species_options, set_value("specie_id"), 'class="form-control chosen-select" data-placeholder="-- Select --" multiple');
                                        ?>
                                        <span class="form-text text-danger"><?= form_error('specie_id[]') ?></span>
                                    </div>
                                </div>
                                <!--./col-md-4 -->

                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Importance (%) <span style="color: red;">*</span></label>
                                        <?= form_input($importance); ?>
                                        <span class="form-text text-danger"><?= form_error('importance') ?></span>
                                    </div>
                                </div>
                            </div> <!-- /.row -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?= form_submit('save', 'Save', array('class' => "btn btn-primary")); ?>
                                    </div> <!-- /form-group -->
                                </div>
                            </div> <!-- /.row -->

                            <?= form_close() ?>
                        </div>
                        <!--./pure-form -->
                    </div>
                    <!--./col-md-12 -->
                </div>
                <!--./row -->
            <?php } ?>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (isset($diseases_symptoms) && $diseases_symptoms) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="5%">#</th>
                                <th width="40%">Species</th>
                                <th width="30%"><?php echo $this->lang->line("label_symptom_name"); ?></th>
                                <th width="15%">Importance (%)</th>
                                <th style="width: 60px; text-align: right;"><?php echo $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($diseases_symptoms as $value) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?php echo $value->specie->title; ?></td>
                                    <td><?php echo $value->symptom->title . ' (' . $value->symptom->code . ')'; ?></td>
                                    <td><?php echo $value->importance; ?></td>
                                    <td>
                                        <?php
                                        echo anchor("ohkr/edit_disease_symptom/" . $disease->id . "/" . $value->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-primary btn-xs"');
                                        echo anchor("ohkr/delete_disease_symptom/" . $disease->id . "/" . $value->id, '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs delete"'); ?>
                                    </td>
                                </tr>
                            <?php $serial++;
                            } ?>
                        </table>

                        <?php if (!empty($links)) : ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No disease symptom has been found', 'warning');
                    } ?>
                </div>
                <!--./col-md-12 -->
            </div><!-- ./row -->
        </div>
    </div>
</div>
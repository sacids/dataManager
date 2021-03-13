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

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="pull-left" style="padding: 3px;">
                                <?= anchor('ohkr/add_disease_symptom/' . $disease->id, '<i class="fa fa-plus"></i> Add Clinical Manifestation', 'class="btn btn-sm btn-primary"') ?>
                            </span>
                        </div>
                    </div><!-- ./row -->


                    <?php if (isset($diseases_symptoms) && $diseases_symptoms) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="5%">S/n</th>
                                <th width="20%">Species</th>
                                <th width="30%"><?php echo $this->lang->line("label_symptom_name"); ?></th>
                                <th width="10%">Importance (%)</th>
                                <th width="20%"><?php echo $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($diseases_symptoms as $value) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?php echo $value->specie->title; ?></td>
                                    <td><?php echo $value->symptom->title; ?></td>
                                    <td><?php echo $value->importance; ?></td>
                                    <td>
                                        <?php echo anchor("ohkr/edit_disease_symptom/" . $disease->id . "/" . $value->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"'); ?>
                                        <?php echo anchor("ohkr/delete_disease_symptom/" . $disease->id . "/" . $value->id, '<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs delete"'); ?>
                                    </td>
                                </tr>
                                <?php $serial++;
                            } ?>
                        </table>

                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No disease symptom has been found', 'warning');
                    } ?>
                </div>
            </div><!-- ./row -->
        </div>
    </div>
</div>

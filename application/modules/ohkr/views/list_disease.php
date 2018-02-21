<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Diseases List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Diseases List</li>
            </ol>

            <?php get_flashdata() ?>

            <div class="row">
                <div class="col-sm-12">
                    <span class="pull-left" style="padding: 3px;">
                        <?= anchor('ohkr/add_new_disease', '<i class="fa fa-plus"></i> Add New Disease', 'class="btn btn-sm btn-primary"') ?>
                    </span>

                    <?php if (isset($disease_list) && $disease_list) { ?>

                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th width="30%"><?= $this->lang->line("label_disease_name"); ?></th>
                                <th width="12%"><?= $this->lang->line("label_specie_name"); ?></th>
                                <th width="16%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($disease_list as $disease) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $disease->disease_title ?></td>
                                    <td><?= $disease->specie_title; ?></td>
                                    <td>
                                        <?= anchor("ohkr/edit_disease/" . $disease->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"'); ?>
                                        <?= anchor("ohkr/delete_disease/" . $disease->id, '<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs delete"'); ?>
                                        <?php //echo anchor("ohkr/disease_symptoms_list/" . $disease->id, "Symptoms"); ?>
                                    </td>
                                </tr>
                                <?php
                                $serial++;
                            } ?>
                        </table>
                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No disease has been found', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

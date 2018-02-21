<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Species List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Species List</li>
            </ol>

            <?php get_flashdata() ?>

            <div class="row">
                <div class="col-sm-12">
                    <span class="pull-left" style="padding: 3px;">
                        <?= anchor('ohkr/add_new_specie', '<i class="fa fa-plus"></i> Add Specie', 'class="btn btn-sm btn-primary"') ?>
                    </span>

                    <?php if (isset($species) && $species) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th></th>
                                <th><?= $this->lang->line("label_specie_name"); ?></th>
                                <th><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($species as $specie) { ?>
                                <tr>
                                    <td><?= $serial; ?></td>
                                    <td><?= $specie->title; ?></td>
                                    <td>
                                        <?= anchor("ohkr/edit_specie/" . $specie->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"'); ?>
                                        <?= anchor("ohkr/delete_specie/" . $specie->id, '<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs delete"'); ?>
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
                        echo display_message('No species has been added', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>

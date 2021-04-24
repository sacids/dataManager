<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Species</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Species</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left" style="padding: 3px;">
                        <?php
                        if (perms_role('Ohkr', 'add_new_specie'))
                            echo anchor('ohkr/add_new_specie', '<i class="fa fa-plus"></i> Add New', 'class="btn btn-sm btn-primary"') ?>
                    </div>
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

            <div class="row">
                <div class="col-sm-12">
                    <?php if (isset($species) && $species) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%">#</th>
                                <th width="80%"><?= $this->lang->line("label_specie_name"); ?></th>
                                <th width="10%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($species as $specie) { ?>
                                <tr>
                                    <td><?= $serial; ?></td>
                                    <td><?= $specie->title; ?></td>
                                    <td>
                                        <?php
                                        if (perms_role('Ohkr', 'edit_specie'))
                                            echo anchor("ohkr/species/edit/" . $specie->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-primary btn-xs"');

                                        if (perms_role('Ohkr', 'delete_specie'))
                                            echo anchor("ohkr/species/delete/" . $specie->id, '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs delete"');
                                        ?>
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
                        echo display_message('No species has been added', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
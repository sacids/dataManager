<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Diseases</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Diseases</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left" style="padding: 3px;">
                        <?= anchor('ohkr/diseases/add_new', '<i class="fa fa-plus"></i> Add New', 'class="btn btn-sm btn-primary"') ?>
                    </div>
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

            <div class="row">
                <div class="col-sm-12">
                    <?php if (isset($diseases) && $diseases) { ?>

                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%">#</th>
                                <th width="40%"><?= $this->lang->line("label_disease_name"); ?></th>
                                <th width="30%"><?= $this->lang->line("label_specie_name"); ?></th>
                                <th width="15%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($diseases as $disease) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $disease->title ?></td>
                                    <td><?= $disease->species; ?></td>
                                    <td>
                                        <?= anchor("ohkr/disease_symptoms/" . $disease->id, 'Symptoms', 'class="btn btn-default btn-xs"'); ?>
                                        <?= anchor("ohkr/diseases/edit/" . $disease->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-primary btn-xs"'); ?>
                                        <?= anchor("ohkr/diseases/delete/" . $disease->id, '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs delete"'); ?>

                                    </td>
                                </tr>
                            <?php
                                $serial++;
                            } ?>
                        </table>

                        <?php if (!empty($links)) : ?>
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
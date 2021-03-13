<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Clinical Manifestation List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Clinical Manifestation</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left" style="padding: 3px;">
                        <?= anchor('ohkr/add_new_symptom', '<i class="fa fa-plus"></i> Add Clinical Manifestation', 'class="btn btn-xs btn-primary"') ?>
                    </div>
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

            <div class="row">
                <div class="col-sm-12">
                    <?php if (isset($symptoms) && $symptoms) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th width="60%"><?= $this->lang->line("label_symptom_name"); ?></th>
                                <th width="30%"><?= $this->lang->line("label_symptom_code"); ?></th>
                                <th width="10%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($symptoms as $symptom) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $symptom->title; ?></td>
                                    <td><?= $symptom->code; ?></td>
                                    <td>
                                        <?= anchor("ohkr/symptoms/edit/" . $symptom->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-primary btn-xs"'); ?>
                                        <?= anchor("ohkr/symptoms/delete/" . $symptom->id, '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs delete"'); ?>
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
                        echo display_message('No clinical manifestation has been found', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
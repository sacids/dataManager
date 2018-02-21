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

            <?php get_flashdata() ?>

            <div class="row">
                <div class="col-sm-12">
                    <span class="pull-left" style="padding: 3px;">
                        <?= anchor('ohkr/add_new_symptom', '<i class="fa fa-plus"></i> Add Clinical Manifestation', 'class="btn btn-sm btn-primary"') ?>
                    </span>

                    <?php if (isset($symptoms) && $symptoms) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th></th>
                                <th><?= $this->lang->line("label_symptom_name"); ?></th>
                                <th><?= $this->lang->line("label_symptom_code"); ?></th>
                                <th><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($symptoms as $symptom) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $symptom->title; ?></td>
                                    <td><?= $symptom->code; ?></td>
                                    <td>
                                        <?= anchor("ohkr/edit_symptom/" . $symptom->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"'); ?>
                                        <?= anchor("ohkr/delete_symptom/" . $symptom->id, '<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs delete"'); ?>
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
                        echo display_message('No clinical manifestation has been found', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

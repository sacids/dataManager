<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= isset($project) ? $project->title : '' ?> Forms</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projects</a></li>
                <li class="active"><?= isset($project) ? $project->title : '' ?> Forms</li>
            </ol>

            <?= get_flashdata() ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="pull-left">
                        <?php if (perms_role('Xform', 'add_new')) { ?>
                            <?= anchor("xform/add_new/" . $project_id, '<i class="fa fa-plus"></i> Add New Form', 'class="btn btn-primary btn-sm"') ?>
                        <?php } ?>

                        <?php if (perms_role('Projects', 'edit')) { ?>
                            <?= anchor('projects/edit/' . $project->id, '<i class="fa fa-pencil"></i> Edit Project', 'class="btn btn-sm btn-warning"') ?>
                        <?php } ?>
                    </div>
                </div>
                <!--./col-md-4 -->

                <div class="col-md-8">
                    <div class="pull-right" style="margin-bottom: 10px;">
                        <?php echo form_open("xform/forms/", 'class="form-inline" role="form"'); ?>

                        <div class="form-group">
                            <?php echo form_input(array('name' => 'name', 'id' => 'name', 'class' => "form-control", 'placeholder' => "Form Name....")); ?>
                        </div>

                        <div class="form-group">
                            <?php echo form_dropdown("access", array("" => "Choose Access", "public" => "Public", "private" => "Private"), NULL, 'class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_dropdown("status", array("" => "Choose status", "published" => "Published", "archived" => "Archived"), NULL, 'class="form-control"'); ?>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <?php echo form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!--./col-md-8 -->
            </div>
            <!--./row -->

            <?php echo validation_errors(); ?>

            <div class="">
                <?php if (!empty($forms)) { ?>
                    <table class="table table-striped table-responsive table-hover table-bordered" cellspacing="0" cellpadding="0">
                        <tr>
                            <th width="3%">#</th>
                            <th width="40%"><?php echo $this->lang->line("label_form_name"); ?></th>
                            <th width="10%">Sent Forms</th>
                            <th width="10%"><?php echo $this->lang->line("label_access"); ?></th>
                            <th width="12%"><?php echo $this->lang->line("label_date_created"); ?></th>
                            <th style="width: 60px;" class="text-center"><?php echo $this->lang->line("label_action"); ?></th>
                            <th style="width: 60px;" class="text-center"><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($forms as $form) { ?>
                            <tr>
                                <td><?= $serial ?></td>
                                <td>
                                    <?php echo '<strong>' . $form->title . '</strong>'; ?>
                                    <?php echo '<p>' . $form->description . '</p>'; ?>
                                </td>
                                <td align="center"><?= $form->sent_forms ?></td>
                                <td>
                                    <?php
                                    if ($form->access == "private") {
                                        echo "<span class='label label-warning'>" . ucfirst($form->access) . "</span>";
                                    } else {
                                        echo "<span class='label label-success'>" . ucfirst($form->access) . "</span>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($form->created_at)); ?></td>
                                <td class="text-center">
                                    <?php if (perms_role('Xform', 'form_data')) { ?>
                                        <div class="dropdown">
                                            <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">View <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><?php echo anchor("xform/form_data/" . $project_id . '/' . $form->id, "Data list"); ?></li>
                                                <li><?php echo anchor("visualization/visualization/chart/" . $project_id . '/' . $form->id, "View Chart"); ?></li>
                                                <li><?php echo anchor("visualization/visualization/map/" . $project_id . '/' . $form->id, "View Map"); ?></li>
                                                <li><?php echo anchor("xform/form_overview/" . $form->form_id, "Overview"); ?></li>
                                                <li><?php echo anchor_popup(base_url() . "assets/forms/definition/" . $form->filename, "Download XML file"); ?></li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php if (perms_role('Xform', 'edit_form')) { ?>
                                        <?php echo anchor("xform/edit_form/" . $project_id . '/' . $form->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-primary btn-xs"'); ?>
                                    <?php } ?>
                                    <?php if ($form->status == "archived") {
                                        if (perms_role('Xform', 'restore_from_archive'))
                                            echo anchor("xform/restore_from_archive/" . $project_id . '/' . $form->id, '<i class="fa fa-folder-open-o"></i>', 'class="btn btn-warning btn-xs unarchive"');
                                    } else {
                                        if (perms_role('Xform', 'archive_xform'))
                                            echo anchor("xform/archive_xform/" . $project_id . '/' . $form->id, '<i class="fa fa-archive"></i>', 'class="btn btn-warning btn-xs archive"');
                                    } ?>
                                    <!--TODO Implement dynamic js prompt -->
                                    <?php
                                    if (perms_role('Xform', 'delete_form'))
                                        echo anchor("xform/delete_form/" . $project_id . '/' . $form->id, '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs delete"'); ?>
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
                <?php } else { ?>
                    <div class="alert alert-warning">You don't have any form to display</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
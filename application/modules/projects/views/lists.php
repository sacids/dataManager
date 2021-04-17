<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $this->lang->line("title_list_projects") ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active"><?= $this->lang->line("title_list_projects") ?></li>
            </ol>

            <div class="row">
                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="col-sm-12 col-md-12 col-lg-12">';
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    echo '</div>';
                }
                ?>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?php if (count($project_list) > 0) { ?>
                        <table class="table table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%">#</th>
                                <th width="24%"><?= $this->lang->line("label_project_title") ?></th>
                                <th width="50%"><?= $this->lang->line("label_project_description") ?></th>
                                <th width="12%"><?= $this->lang->line("label_project_created_date") ?></th>
                                <th style="width: 80px;"><?= $this->lang->line("label_action") ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($project_list as $project) { ?>
                                <tr class="projectRow" id="<?= $project->id ?>">
                                    <td><?php echo $serial; ?></td>
                                    <td><?php echo anchor("projects/forms/" . $project->id, '<b>'.$project->title.'</b>'); ?></td>
                                    <td><?php echo $project->description; ?></td>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($project->created_at)); ?></td>
                                    <td>
                                        <?php echo anchor("projects/forms/" . $project->id, '<i class="fa fa-folder-open"></i>', ['class' => 'btn btn-primary btn-xs']); ?>&nbsp;
                                        <?php echo anchor("projects/edit/" . $project->id, '<i class="fa fa-pencil"></i>', ['class' => 'btn btn-secondary btn-xs']); ?>&nbsp;
                                        <?php echo anchor("projects/lists/#", '<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-xs']); ?>
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
                        <div class="alert alert-warning">No any project at the moment</div>
                    <?php } ?>
                </div>

                <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                    <div id="notificationBar"><?= $this->lang->line("label_select_project_to_list_forms") ?></div>
                    <div id="formsListArea"></div>
                </div> -->
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('tr.projectRow').on('click', function() {
    //         var projectId = $(this).attr('id');

    //         $.ajax({
    //             url: "<?= base_url("projects/forms") ?>/" + projectId,
    //             type: "post",
    //             dataType: 'json',
    //             data: {
    //                 project_id: projectId
    //             },
    //             success: function(data) {
    //                 $("#notificationBar").html("");
    //                 var html = '<h3 class="title"><?= $this->lang->line("title_project_forms") ?> <span class="pull-right"><a class="btn btn-primary btn-xs" href="<?= base_url('xform/add_new') ?>/' + projectId + '"><i class="fa fa-plus"></i> <?= $this->lang->line("button_upload_new_form") ?></a></span></h3>';

    //                 if (data.status == "success" && data.forms_count > 0) {
    //                     var forms = data.forms;

    //                     $.each(forms, function(i, form) {

    //                         var form_status = null;
    //                         if (form.access == "private") {
    //                             form_status = "<span class='pull-right small'>Private</span>";
    //                         } else {
    //                             form_status = "<span class='pull-right small'>Public</span>";
    //                         }

    //                         html += "<div><h4>" + form.title + form_status + "</h4><span class='small'>" + form.description +
    //                             "</span><span class='pull-right'><a class='btn btn-primary btn-xs' href='<?= base_url('xform/edit_form/') ?>" + projectId + "/" + form.id + "'><i class='fa fa-pencil'></i> <?= $this->lang->line("label_edit") ?></a></span>" +
    //                             "<p>" +
    //                             "<a href='<?= base_url("xform/form_overview") ?>/" + form.form_id + "' class='mr-3'>Overview</a>&nbsp;&nbsp;" +
    //                             "<a href='<?= base_url("xform/form_data") ?>/" + projectId + "/" + form.id + "'' class='mr-3'>Form Data</a>&nbsp;&nbsp;" +
    //                             "<a href='<?= base_url("visualization/visualization/chart") ?>/" + projectId + "/" + form.id + "' class='mr-3'>Chart</a>&nbsp;&nbsp;" +
    //                             "<a href='<?= base_url("visualization/visualization/map") ?>/" + projectId + "/" + form.id + "' >Map</a><hr>" +
    //                             "</p></div>";
    //                     });
    //                 }

    //                 if (data.status == "success" && data.forms_count == 0) {
    //                     $("#notificationBar").html('<?= display_message($this->lang->line("message_project_has_no_form"), "info") ?>');
    //                     html = "<div><a class='btn btn-primary btn-xs' href='<?= base_url('xform/add_new') ?>/" + projectId + "'><i class='fa fa-plus'></i> <?= $this->lang->line("button_upload_new_form") ?></a></div>";
    //                 }
    //                 $("#formsListArea").html(html);
    //             },
    //             beforeSend() {
    //                 $("#formsListArea").html("");
    //                 $("#notificationBar").html('<?= display_message("<i class=\"fa fa-spinner fa-refresh fa-spin fa-1x\" aria-hidden=\"true\"></i> " . $this->lang->line("status_message_getting_forms")) ?>');
    //             },
    //             error() {}
    //         });
    //     });
    // });
</script>
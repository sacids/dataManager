<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 25/10/2017
 * Time: 09:50
 */

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Permissions</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><?= anchor('dashboard', 'Dashboard') ?></li>
                <li><?= anchor('auth', 'Auth') ?></li>
                <li class="active">Permissions</li>
                <li class="pull-right"><?= anchor('auth/accesscontrol/new_permission', 'Add New', 'class="pull-right active"') ?></li>
            </ol>

            <div class="row">
                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="col-sm-12 col-md-12 col-lg-12">';
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    echo '</div>';
                }
                ?>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <?php if (count($permissions) > 0) { ?>
                        <table class="table table-responsive table-hover table-bordered">
                            <tr>
                                <th width="12%">Title</th>
                                <th width="65%">Description</th>
                                <th width="15%">Created date</th>
                                <th width="8%" colspan="2">Action</th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($permissions as $perm) { ?>
                                <tr class="filterRow" id="<?= $perm->id ?>">
                                    <td><?php echo $perm->title; ?></td>
                                    <td><?php echo $perm->description; ?></td>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($perm->date_added)); ?></td>
                                    <td><?php echo anchor("auth/accesscontrol/edit_permission/" . $perm->id, "Edit"); ?></td>
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

                    <?php } else { ?>
                        <div class="fail_message">You don't have any permission yet</div>
                        <div class="" style="margin-top:20px;">
                            <?= anchor('auth/accesscontrol/new_permission/', '<button class="btn btn-primary btn-lg">Create your first permission</button>', 'class=""') ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div id="notificationBar">Select permission to see filters</div>
                    <div id="filtersListArea"></div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('tr.filterRow').on('click', function () {
            var permissionId = $(this).attr('id');

            $.ajax({
                url: "<?= base_url("auth/accesscontrol/filters") ?>/" + permissionId,
                type: "post",
                dataType: 'json',
                data: {
                    project_id: permissionId
                },
                beforeSend() {
                    $("#formsListArea").html("");
                    $("#notificationBar").html('<?=display_message('<i class="fa fa-spinner fa-refresh fa-spin fa-1x" aria-hidden="true"></i> Getting filters, Please wait... ')?>');
                },
                success: function (data) {

                    $("#notificationBar").html("");
                    var html = '<h3 class="title">Permission filters <span class="small pull-right"><a href="<?= base_url('auth/accesscontrol/new_filter')?>/' + permissionId + '">Add new filter</a></span></h3>';

                    if (data.status === "success" && data.count > 0) {
                        var filters = data.filters;

                        $.each(filters, function (i, filter) {

                            html += "<div><h4>" + filter.name + "</h4><span class='small'>" + filter.table_name
                                + "</span><span class='pull-right'><a href='<?= base_url('auth/accesscontrol/edit_filter')?>/" + filter.id + "'>Edit</a></span>"
                                + "<p>Condition: " + filter.where_condition + "</p></div>";
                        });
                    }

                    if (data.status === "success" && data.count === 0) {
                        $("#notificationBar").html('<?=display_message("This project does not have any form", "info")?>');
                        html = "<div><a href='<?= base_url('auth/accesscontrol/new_filter')?>/" + permissionId + "'>Add new filter</a></div>";
                    }
                    $("#filtersListArea").html(html);
                },
            });
        });
    });
</script>

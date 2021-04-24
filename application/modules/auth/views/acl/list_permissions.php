<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Access Control</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Access Control</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('auth/accesscontrol/new_permission', '<i class="fa fa-plus"></i> Add new', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <?php if (isset($permissions) && count($permissions) > 0) { ?>
                                <table class="table table-responsive table-hover table-bordered">
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="60%">Title</th>
                                        <th width="20%">Created date</th>
                                        <th width="10%" colspan="2">Action</th>
                                    </tr>

                                    <?php
                                    $serial = 1;
                                    foreach ($permissions as $perm) { ?>
                                        <tr class="filterRow" id="<?= $perm->id ?>">
                                            <td><?= $serial; ?></td>
                                            <td><?= $perm->title; ?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($perm->date_added)); ?></td>
                                            <td>
                                            <?= anchor("auth/accesscontrol/edit_permission/" . $perm->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-primary btn-xs"'); ?>&nbsp;
                                            <?= anchor("auth/accesscontrol/new_filter/" . $perm->id, '<i class="fa fa-plus-square" aria-hidden="true"></i>', 'class="btn btn-secondary btn-xs"'); ?>
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
                                echo display_message('No any access control at the moment', 'warning');
                            } ?>
                        </div><!--./col-md-12 -->
                    </div><!--./row -->
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div><!--./row -->
</div><!--./container -->
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
                    var html = '<h3 class="title">Permission filters <span class="pull-right"><a class="btn btn-primary btn-xs" href="<?= base_url('auth/accesscontrol/new_filter')?>/' + permissionId + '"><i class="fa fa-plus"></i> Add New Filter</a></span></h3>';

                    if (data.status === "success" && data.count > 0) {
                        var filters = data.filters;

                        $.each(filters, function (i, filter) {

                            html += "<div><h4>" + filter.name + "</h4><span class='small'>" + filter.table_name
                                + "</span><span class='pull-right'><a class='btn btn-primary btn-xs' href='<?= base_url('auth/accesscontrol/edit_filter')?>/" + filter.id + "'><i class='fa fa-pencil'></i> Edit</a></span>"
                                + "<p>Condition: " + filter.where_condition + "</p></div><hr>";
                        });
                    }

                    if (data.status === "success" && data.count === 0) {
                        $("#notificationBar").html('<?=display_message("This project does not have any form", "info")?>');
                        html = "<div><a class='btn btn-primary btn-xs' href='<?= base_url('auth/accesscontrol/new_filter')?>/" + permissionId + "'><i class='fa fa-plus'></i> Add new filter</a></div>";
                    }
                    $("#filtersListArea").html(html);
                },
            });
        });
    });
</script>

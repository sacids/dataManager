<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Access Control Filters</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/accesscontrol') ?>">Access Control</a></li>
                <li class="active">Edit Filter</li>
            </ol>

            <div class="row">
                <div class="col-md-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open(uri_string()) ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ACL <span style="color: red">*</span></label>
                                    <?php
                                    $permission_options[''] = "-- Select --";
                                    foreach ($permissions as $permission) {
                                        $permission_options[$permission->id] = $permission->title;
                                    }
                                    echo form_dropdown("filter_permission", $permission_options, set_value("filter_permission", $permission_id), 'class="form-control" id="permissionsList"') ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-4 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Filter Name <span style="color: red">*</span></label>
                                    <?= form_input($filter) ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-4 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Table Name <span style="color: red">*</span></label>
                                    <?php

                                    $tables_options = array_combine($tables, $tables);
                                    $tables_options[''] = "-- Select --";

                                    echo form_dropdown("table", $tables_options, set_value("table", $filter_table), 'class="form-control" id="tablesList"') ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-4 -->
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Column <span style="color: red">*</span></label>
                                    <?= form_dropdown("filter_column", ["" => "-- Select --"], set_value("filter_column"), 'class="form-control filterColumnName"') ?>
                                </div>
                                <!--./form-group-->
                            </div>
                            <!--./col-md-4 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Operation <span style="color: red">*</span></label>
                                    <?php $operators_options = ['=' => "Equal to", '>=' => "Greater or equal to", "<=" => "Less or equal to", ">" => "Greater than", "<" => "Less than", "IS NULL" => "Is null", "NOT NULL" => "Is not null"]; ?>
                                    <?= form_dropdown("filter_operator", $operators_options, set_value("filter_operator"), 'class="form-control"') ?>
                                </div>
                                <!--./form-group-->
                            </div>
                            <!--./col-md-4 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Value <span style="color: red">*</span></label>
                                    <?= form_input($filter_value) ?>
                                </div>
                                <!--./form-group-->
                            </div>
                            <!--./col-md-4 -->
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                    <?= anchor('auth/accesscontrol', 'Cancel', 'class="btn btn-warning"') ?>
                                </div> <!-- /form-group -->
                            </div>
                            <!--./col-md-4 -->
                        </div>
                        <!--./row -->
                        <?= form_close() ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->
        </div>
        <!--./col-md-12 -->
    </div>
    <!--./row -->
</div>
<!--./container -->

<script type="text/javascript">
    $(document).ready(function() {
        $("#tablesList").on("change", function() {
            var tableName = $(this).val();
            getTableColumns(tableName);
        });

        function getTableColumns(tableName) {
            $.get("<?= base_url("auth/accesscontrol/get_table_columns/") ?>/" + tableName, function(data, status) {
                $(".filterColumnName").html(data);
            });
        }
    });
</script>
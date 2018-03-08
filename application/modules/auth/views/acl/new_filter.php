<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">New Filter</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/accesscontrol') ?>">User Permissions</a></li>
                <li class="active">New Filter</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open(uri_string()) ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Filter name <span style="color: red">*</span></label>
                            <?= form_input($filter) ?>
                        </div><!--./form-group -->

                        <div class="form-group">
                            <label>Permissions <span style="color: red">*</span></label>
                            <?php
                            $permission_options[''] = "Select permission";
                            foreach ($permissions as $permission) {
                                $permission_options[$permission->id] = $permission->title;
                            }
                            echo form_dropdown("filter_permission", $permission_options, set_value("filter_permission", $permission_id), 'class="form-control" id="permissionsList"') ?>
                        </div><!--./form-group -->

                        <div class="form-group">
                            <label>Table name <span style="color: red">*</span></label>
                            <?php

                            $tables_options = array_combine($tables, $tables);
                            $tables_options[''] = "Choose table";

                            echo form_dropdown("table", $tables_options, set_value("table"), 'class="form-control" id="tablesList"') ?>
                        </div><!--./form-group -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Conditions <span></span></label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Column <span style="color: red">*</span></label>
                                            <?= form_dropdown("filter_column", ["" => "Select column"], set_value("filter_column"), 'class="form-control filterColumnName"') ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Operator <span style="color: red">*</span></label>
                                            <?php $operators_options = ['=' => "Equal to", '>=' => "Greater or equal to", "<=" => "Less or equal to", ">" => "Greater than", "<" => "Less than", "IS NULL" => "Is null", "NOT NULL" => "Is not null"]; ?>
                                            <?= form_dropdown("filter_operator", $operators_options, set_value("filter_operator"), 'class="form-control"') ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Value <span style="color: red">*</span></label>
                                            <?= form_input($filter_value) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--./form-group -->

                        <div class="form-group">
                            <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                            <?= anchor('auth/accesscontrol', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                        <?= form_close() ?>
                    </div><!--./col-sm-6 -->
                </div><!--./col-sm-12 -->
            </div><!--./row -->

        </div>
    </div>
</div><!--./container -->

<script type="text/javascript">

    $(document).ready(function () {

        $("#tablesList").on("change", function () {
            var tableName = $(this).val();

            getTableColumns(tableName);
        });

        function getTableColumns(tableName) {

            $.get("<?=base_url("auth/accesscontrol/get_table_columns/")?>/" + tableName, function (data, status) {
                $(".filterColumnName").html(data);

            });
        }
    });

</script>
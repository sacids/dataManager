<?php
/**
 * Created by PhpStorm.
 * User: Godlcuk Akyoo
 * Date: 25/10/2017
 * Time: 12:08
 */ ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h3><i class="fa fa-filter"></i> New Filter</h3>
            <hr/>
            <?= get_flashdata() ?>

            <?= form_open("auth/accesscontrol/new_filter/{$permission_id}", 'class="form-horizontal" role="form"') ?>
            <div class="form-group">
                <label>Filter name <span>*</span></label>
                <input type="text" id="filterName" name="filter" placeholder="Enter filter name" class="form-control"
                       value="<?php echo set_value('filter'); ?>">
                <div class="error" style="color: red"> <?php echo form_error('filter'); ?></div>
            </div>

            <div class="form-group">
                <label>Permissions <span>*</span></label>
                <?php

                $permission_options[''] = "Select permission";

                foreach ($permissions as $permission) {
                    $permission_options[$permission->id] = $permission->title;
                }

                ?>
                <?= form_dropdown("filter_permission", $permission_options, set_value("filter_permission", $permission_id), 'class="form-control" id="permissionsList"') ?>
                <div class="error" style="color: red"> <?php echo form_error('filter_permission'); ?></div>
            </div>

            <div class="form-group">
                <label>Table name <span>*</span></label>
                <?php

                $tables_options = array_combine($tables, $tables);
                $tables_options[''] = "Choose table";

                ?>
                <?= form_dropdown("table", $tables_options, set_value("table", ""), 'class="form-control" id="tablesList"') ?>
                <div class="error" style="color: red"> <?php echo form_error('table'); ?></div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-10">
                        <label>Conditions <span></span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Column <span>*</span></label>
                                <?= form_dropdown("filter_column[]", ["" => "Select column"], set_value("filters[]"), 'class="form-control filterColumnName"') ?>
                                <div class="error" style="color: red"><?= form_error('filter_column[]'); ?></div>
                            </div>
                            <div class="col-md-4">
                                <label>Operator <span>*</span></label>
                                <?php $operators_options = ['=' => "Equal to", '>=' => "Greater or equal to", "<=" => "Less or equal to", ">" => "Greater than", "<" => "Less than", "IS NULL" => "Is null", "NOT NULL" => "Is not null"]; ?>
                                <?= form_dropdown("filter_operator[]", $operators_options, set_value("filter_operator[]"), 'class="form-control"') ?>
                                <div class="error" style="color: red"><?= form_error('filter_operator[]'); ?></div>
                            </div>
                            <div class="col-md-4">
                                <label>Value <span>*</span></label>
                                <?= form_input("filter_value[]", set_value("filter_value"), 'class="form-control"') ?>
                                <div class="error" style="color: red"><?= form_error('filter_value[]'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add another filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

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
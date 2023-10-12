<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Access Control Filters</h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <?php
            foreach ($links as $key => $link) {
                echo $link;
            }
            ?>
        </div>
    </div>
</div>
</header>

<main class="bg-white h-full relative">
    <div class="h-full overflow-y-scroll">
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <?php if ($this->session->flashdata('message') != "") { ?>
                <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php echo form_open(uri_string(), 'role="form" class="bg-gray-100 px-2 py-2"'); ?>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        ACL <span class="text-red-500">*</span>
                    </label>
                    <?php
                    $permission_options[''] = "-- Select --";
                    foreach ($permissions as $permission) {
                        $permission_options[$permission->id] = $permission->title;
                    }
                    echo form_dropdown("filter_permission", $permission_options, set_value("filter_permission", $permission_id), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="permissionsList"') ?>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Filter Name
                    </label>
                    <?= form_input($filter) ?>
                </div>


                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Table Name
                    </label>
                    <?php
                    $tables_options = array_combine($tables, $tables);
                    $tables_options[''] = "-- Select --";

                    echo form_dropdown("table", $tables_options, set_value("table"), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="tablesList"') ?>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Column
                    </label>
                    <?= form_dropdown("filter_column", ["" => "-- Select --"], set_value("filter_column"), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 filterColumnName"') ?>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Operation
                    </label>
                    <?php $operators_options = ['=' => "Equal to", '>=' => "Greater or equal to", "<=" => "Less or equal to", ">" => "Greater than", "<" => "Less than", "IS NULL" => "Is null", "NOT NULL" => "Is not null"]; ?>
                    <?= form_dropdown("filter_operator", $operators_options, set_value("filter_operator"), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"') ?>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Value
                    </label>
                    <?= form_input($filter_value) ?>
                </div>
            </div>

            <div class="flex items-start">
                <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </div>
            <?php echo form_close(); ?>

            <?php if (isset($permissions) && $permissions) { ?>
                <div class="relative overflow-x-auto">
                    <table id="dt" class="table table-bordered dt-responsive nowrap w-100 table-fixed">
                        <thead class="text-gray-600 text-sm font-medium">
                            <tr>
                                <th width="50%">Title</th>
                                <th width="20%">Table Name</th>
                                <th width="20%">Condition</th>
                                <th width="8%"></th>
                            </tr>
                        </thead>

                        <tbody class="overflow-y-scroll text-gray-600 text-sm font-normal">
                            <?php
                            $serial = 1;
                            foreach ($filters as $val) { ?>
                                <tr class="bg-white border-b">
                                    <td class="px-2 py-1 text-left whitespace-nowrap">
                                        <?= $val->name ?>
                                    </td>
                                    <td class="px-2 py-1">
                                        <?= $val->table_name ?>
                                    </td>

                                    <td class="px-2 py-1">
                                        <?= $val->where_condition ?>
                                    </td>

                                    <td class="px-2 py-1 text-center font-medium text-gray-700 flex flex-row">
                                        <?php if ($this->ion_auth->is_admin()) { ?>
                                            <a href="<?= site_url("auth/accesscontrol/delete_permission/" . $perm->id) ?>" class="text-gray-600 hover:text-red-800 pr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                                $serial++;
                            } ?>
                        </tbody>
                    </table>

                </div>
            <?php } else { ?>
                <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline text-sm font-normal">No any access control found</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            <?php } ?>

        </div>
    </div>
</main>

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
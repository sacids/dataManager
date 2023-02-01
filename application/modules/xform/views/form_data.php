<div class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <a href="<?= site_url('projects/forms/' . $project->id) ?>" class="text-red-900"><?= isset($project) ? $project->title : '' ?></a> > <?= $form->title ?>
        </h1>
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


<main class="bg-white h-full flex overflow-hidden">
    <div class="flex-1 h-full overflow-y-scroll">
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <?php echo form_open(uri_string()); ?>
            <div class="flex flex-row mb-0">
                <div>
                    <input type="text" id="myCustomSearchBox" class="w-60 mr-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-24" placeholder="Search here...">
                </div>

                <div>
                    <input type="date" name="start_at" class="w-60 mr-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-2" />
                </div>

                <div>
                    <input type="date" name="end_at" class="w-60 mr-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 py-2 pr-2" />
                </div>

                <div>
                    <button type="submit" name="filter" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-normal rounded-0 text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>
                </div>

                <div class="flex items-end self-end ml-4">
                    <a href="<?= site_url("xform/xls_export_form_data/?form_id=" . $form_id . '&start_at=' . $start_at . '&end_at=' . $end_at) ?>" class="text-white bg-green-800 hover:bg-green-900 font-normal rounded-0 text-sm px-5 py-2.5">
                        <i class="fa-solid fa-file-csv text-white"></i> Export
                    </a>
                </div>
            </div>
            <?php echo form_close(); ?>

            <?php if ($this->session->flashdata('message') != "") { ?>
                <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-2 mt-2" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (isset($form_data) && $form_data) { ?>
                <div class="relative overflow-x-auto">
                    <?= form_open("xform/delete_entry/" . $project->id . '/' . $form->id, array("role" => "form")); ?>
                    <?= form_hidden("table_name", $form_id); ?>
                    <table id="dt" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead class="text-gray-600 text-sm font-medium">
                            <tr>
                                <th scope="col" class="text-center">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <?php
                                if (isset($selected_columns)) {
                                    foreach ($selected_columns as $column) {
                                        echo '<th scope="col" class="px-4 py-3">' . $column . '</th>';
                                    }
                                } else {
                                    foreach ($mapped_fields as $key => $column) {
                                        if (array_key_exists($column, $field_maps)) {
                                            echo '<th scope="col" class="px-4 py-3">' . $field_maps[$column] . '</th>';
                                        } else {
                                            echo '<th scope="col" class="px-4 py-3">' . $column . '</th>';
                                        }
                                    }
                                } ?>
                            </tr>
                        </thead>

                        <tbody class="overflow-y-scroll text-gray-600 text-sm font-normal">
                            <?php
                            foreach ($form_data as $data) {
                                echo "<tr data-id=" . $data->id . "  form-id=" . $form_id . ">";
                                foreach ($data as $key => $entry) {

                                    if ($key == "id") {
                                        echo "<td class='px-4 py-3'>" . form_checkbox("entry_id[]", $entry) . "</td>";
                                    }

                                    if ($key == "meta_instanceID") {
                                        echo "<td class='px-4 py-3 dt-click' data-id=" . $data->id . "  form-id=" . $form_id . ">" . $entry . "</td>";
                                    } else {
                                        if ($key == "meta_username") {
                                            echo "<td class='px-4 py-3'>" . get_collector_name_from_phone($entry) . '<br />' . $entry . "</td>";
                                        } else {
                                            if (preg_match('/(\.jpg|\.png|\.bmp)$/', $entry)) {
                                                echo "<td class='py-3'><img src=' " . base_url() . "assets/forms/data/images/" . $entry . "' style='max-width:100px;' /></td>";
                                            } else {
                                                echo "<td class='px-4 py-3'>" . $entry . "</td>";
                                            }
                                        }
                                    }
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="flex flex-row justify-between">
                        <div>
                            <button type="submit" name="delete" class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 font-normal rounded-0 text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                Delete Selected
                            </button>
                        </div>

                        <div>
                            <?php if (!empty($page_links)) : ?>
                                <nav aria-label="Page navigation example">
                                    <?= $page_links ?>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            <?php } else { ?>
                <div class="w-full bg-red-100 border border-red-400 text-red-700 mt-4 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline text-sm font-normal">No any form found</span>
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

    <div id="offcanvas-wrp"></div>
</main>

<script>
    $(document).ready(function() {
        //close offcanvas wrp
        $('#offcanvas-wrp').hide();

        $(document).on('click', '.dt-click', function(event) {
            event.preventDefault();

            $('#offcanvas-wrp').animate({
                width: "show"
            });


            var formId = $(this).attr('form-id');
            var dataId = $(this).attr('data-id');
            var url = window.location.origin + '/feedback/form_data_preview/' + formId + '/' + dataId;

            var jqXHR = $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                //offcanvas
                $('#offcanvas-wrp').html(data);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert('Failed to update progress');
                if (console && console.log) {
                    console.log("Loading Ajax: " + textStatus + ", " + errorThrown);
                }
            });

        });

    });



    // $(document).on('click', '#datatable tbody tr', function(event) {
    //     event.preventDefault();

    //     $('#datatable tbody tr').removeClass('tr_active');
    //     $(this).addClass('tr_active');

    //     var eid = $(this).attr('eid')
    //     var url = window.location.origin + '/ems/utils/me?eid=' + eid;

    //     var jqXHR = $.ajax({
    //         type: "GET",
    //         url: url,
    //     }).done(function(data) {
    //         //alert(data)

    //         $('#event_content').html(data);

    //     }).fail(function(jqXHR, textStatus, errorThrown) {
    //         alert('Failed to update progress');
    //         if (console && console.log) {
    //             console.log("Loading Ajax: " + textStatus + ", " + errorThrown);
    //         }
    //     });

    // });





    // function manageData() {
    //     return {
    //         sidebarOpen: false,

    //         getFormData(id) {
    //             // get form data using fetch
    //             var url = window.location.origin + '/feedback/details/' + id;
    //             fetch(url)
    //                 .then(response => response.text())
    //                 .then(data => {
    //                     // put data in div
    //                     $('#form_data_wrp').html(data);
    //                 })
    //         },
    //     }
    // }
</script>
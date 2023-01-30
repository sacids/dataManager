<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?> > <?= $form->title ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Overview
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url("xform/form_data/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Table
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("visualization/visualization/chart/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Charts
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("visualization/visualization/map/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Map
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/mapping/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Mapping Fields
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/permissions/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Permission
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="bg-white h-full flex overflow-hidden">
    <div class="flex-1 h-full overflow-y-scroll">
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <?php if (isset($form_data) && $form_data) { ?>
                <div class="relative overflow-x-auto">
                    <div class="">
                        <input type="text" id="myCustomSearchBox" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 mb-3" placeholder="Search here...">
                    </div>

                    <table id="dt" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead class="text-gray-600 text-sm font-medium">
                            <th scope="col" class="text-center">
                                <input type="checkbox" id="select-all">
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
                                echo "<tr data-id=" . $data->id . "  form-id=".$form_id.">";
                                foreach ($data as $key => $entry) {

                                    if ($key == "id") {
                                        echo "<td class='px-4 py-3'>" . form_checkbox("entry_id[]", $entry) . "</td>";
                                    }

                                    if ($key == "meta_instanceID") {
                                        echo '<td class="px-4 py-3">' . $entry . '</td>';
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
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="offcanvas-wrp"></div>
</main>



<style>
    .table-bordered td,
    .table-bordered th {
        border: 1px dashed #dcdcdc;
        border-top: 1px solid #dcdcdc;
        border-bottom: 1px solid #dcdcdc;
    }

    .table-bordered td:first-child,
    .table-bordered th:first-child {
        border-left: 1px solid #fff;
    }

    .table-bordered td:last-child,
    .table-bordered th:last-child {
        border-right: 1px solid #fff;
    }

    .table>:not(:last-child)>:last-child>* {
        border-bottom-color: #dcdcdc;
    }


    #offcanvas-wrp {
        width: calc(63vw - 150px);
        height: calc(100vh - 80px);
        overflow-y: scroll;
        background-color: #EEEEEE;
    }
</style>

<script>
    $(document).ready(function() {
        //close offcanvas wrp
        $('#offcanvas-wrp').hide();

        $(document).on('click', '#dt tbody tr', function(event) {
            event.preventDefault();

            $('#offcanvas-wrp').animate({
                width: "show"
            });


            var formId = $(this).attr('form-id');
            var dataId = $(this).attr('data-id');
            var url    = window.location.origin + '/feedback/form_data_preview/'+ formId + '/' + dataId;

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
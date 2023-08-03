<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Diseases</h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
        <?php
            foreach ($page_links as $key => $link) {
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

            <?php if (isset($diseases) && $diseases) { ?>
                <div class="relative overflow-x-auto">
                    <div class="flex flex-row justify-between mb-3">
                        <div>
                            <input type="text" id="myCustomSearchBox" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-24" placeholder="Search here...">
                        </div>

                        <div>
                            <!-- <a href="#" class="text-white bg-green-800 hover:bg-green-900 font-medium rounded text-sm px-5 py-3">
                            <i class="fa-solid fa-file-export text-white"></i> XLS
                        </a> -->
                        </div>
                    </div>

                    <table id="dt" class="table table-bordered dt-responsive nowrap w-100 table-fixed">
                        <thead class="text-gray-600 text-sm font-medium">
                            <tr>
                                <th width="3%">#</th>
                                <th width="40%"><?= $this->lang->line("label_disease_name"); ?></th>
                                <th width="30%"><?= $this->lang->line("label_specie_name"); ?></th>
                                <th width="15%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>
                        </thead>

                        <tbody class="overflow-y-scroll text-gray-600 text-sm font-normal">
                            <?php
                            $serial = 1;
                            foreach ($diseases as $disease) { ?>
                                <tr class="bg-white border-b">
                                    <td><?= $serial ?></td>
                                    <td><?= anchor("ohkr/disease_symptoms/" . $disease->id, $disease->title, '') ?></td>
                                    <td><?= $disease->species; ?></td>
                                    <td>
                                        <?php
                                        if (perms_role('Ohkr', 'disease_symptoms_list'))
                                            echo anchor("ohkr/disease_symptoms/" . $disease->id, '<i class="fa fa-stethoscope"></i>', 'class="btn btn-primary btn-xs"') . '&nbsp;';
                                        if (perms_role('Ohkr', 'edit_disease'))
                                            echo anchor("ohkr/diseases/edit/" . $disease->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-secondary btn-xs"') . '&nbsp;';
                                        // if (perms_role('Ohkr', 'delete_disease'))
                                        //     echo anchor("ohkr/diseases/delete/" . $disease->id, '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs delete"');
                                        ?>

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
                    <span class="block sm:inline text-sm font-normal">No any disease at the moment</span>
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
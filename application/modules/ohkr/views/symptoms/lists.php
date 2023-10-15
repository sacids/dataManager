<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Symptômes</h1>
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

<main class="bg-white h-[calc(100%-9rem)] flex overflow-hidden relative">
    <div class="flex-1 h-full overflow-y-scroll">
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

            <div class="flex flex-row justify-between my-3">
                <div>
                    <a href="<?= site_url('ohkr/symptoms/add_new')?>" class="text-white bg-red-800 hover-bg-red-900 font-medium rounded text-sm px-5 py-3">
                        <i class="fa-solid fa-plus text-white"></i> Ajouter un nouveau symptôme
                    </a>
                </div>

                <div>
                    <input type="text" id="myCustomSearchBox" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-24" placeholder="Rechercher ici...">
                </div>  
            </div>

            <?php if (isset($symptoms) && $symptoms) { ?>
                <table id="dt" class="table table-bordered dt-responsive nowrap w-100 table-fixed">
                    <thead class="text-gray-600 text-sm font-medium">
                        <tr>
                            <th width="3%">#</th>
                            <th width="10%">#</th>
                            <th width="40%"><?= $this->lang->line("label_symptom_name"); ?></th>
                            <th width="20%"><?= $this->lang->line("label_symptom_code"); ?></th>
                            <th width="15%"><?= $this->lang->line("label_action"); ?></th>
                        </tr>
                    </thead>

                    <tbody class="overflow-y-scroll text-gray-600 text-sm font-normal">
                        <?php
                        $serial = 1;
                        foreach ($symptoms as $symptom) { ?>
                            <tr class="bg-white border-b">
                                <td><?= $serial ?></td>
                                <td>
                                    <?php
                                    if ($symptom->photo != '') {
                                        if (file_exists('./assets/forms/data/images/thumb_' . $symptom->photo))
                                            echo '<img width="60" src="' . base_url('assets/forms/data/images/thumb_' . $symptom->photo) . '" alt="" />';
                                        else
                                            echo '<img width="60" src="http://placehold.it/400x300" alt="">';
                                    } else {
                                        echo '<img width="60" src="http://placehold.it/400x300" alt="">';
                                    } ?>
                                </td>
                                <td><?= $symptom->title; ?></td>
                                <td><?= $symptom->code; ?></td>
                                <td>
                                    <?php
                                    if (perms_role('Ohkr', 'edit_symptom'))
                                        echo anchor("ohkr/symptoms/edit/" . $symptom->id, '<i class="fa-regular fa-pen-to-square"></i>', 'class="btn btn-primary btn-xs"'). '&nbsp;&nbsp;';

                                    if (perms_role('Ohkr', 'delete_symptom'))
                                        anchor("ohkr/symptoms/delete/" . $symptom->id, '<i class="fa-regular fa-trash-can text-red-400"></i>', 'class="btn btn-danger btn-xs delete"');
                                    ?>
                                </td>
                            </tr>
                        <?php
                            $serial++;
                        } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline text-sm font-normal">Aucun symptôme pour le moment</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Fermer</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900"><?= isset($project) ? $project->title : '' ?></h1>
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

            <div class="flex flex-row justify-between mb-3">
                <div>
                    <input type="text" id="myCustomSearchBox" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-24" placeholder="Rechercher ici...">
                </div>
                <div>
                </div>
            </div>

            <?php if (!empty($forms)) { ?>
                <table id="dt" class="table table-bordered dt-responsive nowrap table-fixed">
                    <thead class="text-gray-600 text-sm font-medium">
                        <tr>
                            <th width="24%">Titre</th>
                            <th width="36%">Description</th>
                            <th width="10%">Statut</th>
                            <th width="10%">Soumission</th>
                            <th width="12%">Créé le</th>
                            <th width="8%"></th>
                        </tr>
                    </thead>

                    <tbody class="overflow-y-scroll text-gray-600 text-sm font-normal">
                        <?php
                        foreach ($forms as $form) { ?>
                            <tr class="bg-white border-b">
                                <td class="px-1 py-4 text-left whitespace-nowrap">
                                    <p class="font-semibold text-gray-800 truncate">
                                        <?php echo anchor("xform/form_data/" . $project_id . '/' . $form->id, $form->title); ?>
                                    </p>
                                </td>

                                <td class="">
                                    <p class="truncate">
                                        <?php echo $form->description; ?>
                                    </p>
                                </td>

                                <td class="px-1 py-4 text-center font-normal text-sm text-gray-600 whitespace-nowrap">
                                    <?php
                                    if ($form->access == "private")
                                        echo "<span class='bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded  border border-yellow-300'>" . ucfirst($form->access) . "</span>";
                                    else
                                        echo "<span class='bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-green-400'>" . ucfirst($form->access) . "</span>";
                                    ?>
                                </td>
                                <td class="px-1 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo number_format($form->sent_forms); ?></td>
                                <td class="px-1 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo date('d-m-Y H:i:s', strtotime($form->created_at)); ?></td>
                                <td class="px-1 py-4 text-center font-medium text-gray-700 flex flex-row">
                                    <?php if (perms_role('Xform', 'edit_form')) { ?>
                                        <a href="<?= site_url("xform/edit_form/" . $project_id . '/' . $form->id) ?>" class="text-gray-600 hover:text-gray-900 pr-2">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    <?php } ?>

                                    <?php if ($this->ion_auth->is_admin()) { ?>
                                        <a href="<?= base_url("assets/forms/definition/" . $form->filename) ?>" target="_blank" class="text-gray-600 hover:text-gray-900 pr-2">
                                         <i class="fa-solid fa-file-arrow-down"></i>
                                        </a>
                                    <?php } ?>

                                    <?php if ($this->ion_auth->is_admin()) { ?>
                                        <a href="<?= site_url("xform/delete_form/" . $project_id . '/' . $form->id) ?>" class="text-gray-600 hover:text-red-800">
                                        <i class="fa-regular fa-trash-can text-red-400"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline text-sm font-normal">Aucun formulaire pour le moment</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Fermer</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"></path>
                        </svg>
                    </span>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

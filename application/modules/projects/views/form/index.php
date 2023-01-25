<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Details
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url('projects/forms/' . $project_id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        List Forms
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/add_new/" . $project_id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Upload Form
                    </a>
                </li>

                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Settings
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">
            <div class="w-full">
                <div class="relative overflow-x-auto">
                    <?php if ($this->session->flashdata('message') != "") { ?>
                        <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-4" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($forms)) { ?>
                        <table class="w-full text-sm text-left text-gray-900">
                            <thead class="text-xs text-gray-700  bg-white dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Color
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <?php
                                foreach ($forms as $form) { ?>
                                    <tr class="bg-white border-b">
                                        <td class="px-0 py-4 text-left whitespace-nowrap">
                                            <span class="font-semibold text-gray-800"><?php echo anchor("xform/form_data/" . $project_id . '/' . $form->id, $form->title); ?></span>
                                            <p class="pt-2 text-gray-600"><?php echo $form->description; ?></p>

                                        </td>
                                        <td class="px-0 py-4 text-left font-medium text-gray-700 whitespace-nowrap"></td>
                                        <td class="px-0 py-4 text-left font-medium text-gray-700 whitespace-nowrap">
                                            <?php
                                            if ($form->access == "private")
                                                echo "<span class='bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300'>" . ucfirst($form->access) . "</span>";
                                            else
                                                echo "<span class='bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400'>" . ucfirst($form->access) . "</span>";
                                            ?>
                                        </td>
                                        <td class="px-0 py-4 text-left font-medium text-gray-700 whitespace-nowrap"><?php echo number_format($form->sent_forms); ?></td>
                                        <td class="px-0 py-4 text-left font-medium text-gray-700 whitespace-nowrap"><?php echo date('d-m-Y H:i:s', strtotime($form->created_at)); ?></td>
                                        <td class="px-0 py-4 text-left font-medium text-gray-700 whitespace-nowrap">
                                            <?php if (perms_role('Xform', 'edit_form')) { ?>
                                                <?php echo anchor("xform/edit_form/" . $project_id . '/' . $form->id, 'Edit', ['class' => '']); ?>&nbsp;|
                                            <?php } ?>

                                            <?php if ($this->ion_auth->is_admin()) { ?>
                                                <a href="<?= site_url("xform/delete_form/" . $project_id . '/' . $form->id) ?>" class="">Delete</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline text-sm font-normal">No any form at the moment</span>
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
        </div>
        <!-- /End replace -->
    </div>
</main>
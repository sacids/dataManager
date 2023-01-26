<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Projects</h1>
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

                    <?php if (count($project_list) > 0) { ?>
                        <table class="w-full text-sm text-left">
                            <thead class="text-left text-sm font-medium text-gray-700  bg-white border-b">
                                <tr>
                                    <th scope="col" class="py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="py-3">
                                        Created On
                                    </th>
                                    <th scope="col" class="py-3">

                                    </th>

                                    <th scope="col" class="py-3">

                                    </th>

                                </tr>
                            </thead>

                            <tbody class="bg-white border-b hover:bg-gray-50">
                                <?php
                                foreach ($project_list as $project) { ?>
                                    <tr class="bg-white border-b" id="<?= $project->id ?>">
                                        <td class="px-0 py-4 text-left whitespace-nowrap">
                                            <span class="font-medium text-gray-800"><?php echo anchor("projects/forms/" . $project->id, $project->title); ?></span>
                                        </td>

                                        <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                                            <p class="ellipe"> <?php echo $project->description; ?></p>
                                        </td>
                                        <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo date('d-m-Y H:i:s', strtotime($project->created_at)); ?></td>
                                        
                                        <td class="px-1 py-4 text-leftwhitespace-nowrap">
                                            <?php if (perms_role('Projects', 'edit')) { ?>
                                                <a href="<?= site_url("projects/edit/" . $project->id) ?>" class="text-gray-600 hover:text-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                            <?php } ?>
                                        </td>

                                        <td class="px-1 py-4 text-left whitespace-nowrap">
                                            <?php if ($this->ion_auth->is_admin()) { ?>
                                                <a href="<?= site_url("projects/delete/" . $project->id) ?>" class="text-gray-600 hover:text-red-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">No any project at the moment</span>
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
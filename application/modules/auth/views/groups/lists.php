<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Manage Roles</h1>
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

            <div class="flex flex-row justify-between mb-0">
                <div>
                    <input type="text" id="myCustomSearchBox" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-24" placeholder="Search here...">
                </div>

                <div>
                    <!-- <?php if ($this->ion_auth->is_admin() || perms_role('auth', 'create_group')) { ?>
                        <a href="<?= site_url('auth/groups/create') ?>" class="text-white bg-red-900 hover:bg-red-800 font-normal rounded text-sm px-4 py-2">
                            Create
                        </a>
                    <?php } ?> -->
                </div>
            </div>

            <?php if (isset($groups) && $groups) { ?>
                <div class="relative overflow-x-auto">
                    <table id="dt" class="table table-bordered dt-responsive nowrap w-100 table-fixed">
                        <thead class="text-gray-600 text-sm font-medium">
                            <tr>
                                <th width="20%">Role Name</th>
                                <th width="70%">Description</th>
                            </tr>
                        </thead>

                        <tbody class="overflow-y-scroll text-gray-600 text-sm font-normal">
                            <?php
                            $serial = 1;
                            foreach ($groups as $values) { ?>
                                <tr class="bg-white border-b">
                                    <td class="px-2 py-1 text-left whitespace-nowrap">
                                    <?= $values->name; ?>
                                    </td>
                                    <td class="px-2 py-1"><?= $values->description; ?></td>

                                    
                                </tr>
                            <?php
                                $serial++;
                            } ?>
                        </tbody>
                    </table>

                </div>
            <?php } else { ?>
                <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline text-sm font-normal">No any role found</span>
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
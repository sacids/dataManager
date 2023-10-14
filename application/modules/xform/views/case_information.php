<div class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <a href="<?= site_url('projects/forms/' . $project->id) ?>" class="text-red-900"><?= isset($project) ? $project->title : '' ?></a> > Form Permission - <?= $form->title ?>
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

            <?php if (!empty($cases)) { ?>

                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 table-fixed">
                    <thead class="text-gray-600 text-sm font-medium">
                        <tr>
                            <th width="24%">Attended</th>
                            <th width="24%">Attended By</th>
                            <th width="24%">Attended Date</th>
                            <th width="24%">Disease</th>
                            <th width="48%">Action Taken</th>
                            <th width="48%">Reported E-Mai</th>
                            <th width="12%">Created At</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-600 text-sm font-normal">
                        <?php
                        $serial = 1;
                        foreach ($cases as $values) { ?>
                            <tr class="bg-white border-b">
                                <td class="px-2 py-1 text-left whitespace-nowrap"></td>

                                <td class="px-2 py-1 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                                    <?php echo date('d-m-Y H:i:s', strtotime($values->created_at)); ?>
                                </td>
                            </tr>
                        <?php
                            $serial++;
                        } ?>
                    </tbody>
                </table>


            <?php } else { ?>
                <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline text-sm font-normal">No any case at the moment</span>
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
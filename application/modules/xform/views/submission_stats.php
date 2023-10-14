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

<main class="bg-white h-[calc(100%-9rem)] flex overflow-hidden relative">
    <div class="flex-1 h-full overflow-y-scroll">
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <?php if (isset($arr_data) && $arr_data) { ?>
                <div class="relative overflow-x-auto">

                    <div class="flex flex-row justify-between mb-3">
                        <div></div>
                        <div>
                            <input type="text" id="myCustomSearchBox" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500 block pr-24" placeholder="Search here...">
                        </div>
                    </div>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 table-fixed">
                        <thead class="text-gray-600 text-sm font-medium">
                            <tr>
                                <th width="3%">#</th>
                                <th width="60%">Full Name</th>
                                <th width="10%">Username</th>
                                <th width="10%">No. of Submission</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-600 text-sm font-normal">

                            <?php
                            $serial = 1;
                            foreach ($arr_data as $val) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $val['name']; ?></td>
                                    <td><?= $val['phone']; ?></td>
                                    <td align="right"><?= number_format($val['submission']) ?></td>
                                </tr>
                            <?php $serial++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
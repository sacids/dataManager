<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <a href="<?= site_url('projects/forms/' . $project->id) ?>" class="text-red-900"><?= isset($project) ? $project->title : '' ?></a> > <?= $form->title ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <?php
            foreach ($links as $key => $link) {
                echo $link;
            }
            ?>
        </div>
    </div>
</header>

<main class="bg-white h-full flex overflow-hidden">
    <div class="flex-1 h-full overflow-y-scroll">
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <?php if (isset($data_collectors) && $data_collectors) { ?>
                <div class="relative overflow-x-auto">
                    <table class="table table-striped table-responsive table-hover table-bordered" cellspacing="0" cellpadding="0">
                        <tr>
                            <th width="3%">#</th>
                            <th width="60%">Full Name</th>
                            <th width="10%">Username</th>
                            <th width="10%">No. of Submission</th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($data_collectors as $val) { ?>
                            <tr>
                                <td><?= $serial ?></td>
                                <td><?= $val->first_name . ' ' . $val->last_name; ?></td>
                                <td><?= $val->username; ?></td>
                                <td align="right"><b><?= number_format($val->submission) ?></b></td>
                            </tr>
                        <?php $serial++;
                        } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
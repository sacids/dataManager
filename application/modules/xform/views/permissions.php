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


            <?php echo form_open(uri_string(), 'role="form"'); ?>
            <h4 class="uppercase font-semibold text-sm mb-3">
                <?= $this->lang->line("label_group_permissions") ?>
            </h4>
            <table>
                <tr>
                    <?php
                    $serial = 0;
                    foreach ($group_perms as $key => $value) {
                        if (($serial % 2) == 0) {
                            echo '</tr><tr>';
                        } ?>
                        <td>
                            <?= form_checkbox("perms[]", $key, (in_array($key, $current_perms)) ? TRUE : FALSE); ?>
                            <?= ucfirst($value); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    <?php $serial++;
                    } ?>
                </tr>
            </table>


            <h4 class="uppercase font-semibold text-sm mb-3 mt-4">
                <?= $this->lang->line("label_user_permissions") ?>
            </h4>

            <?php
            $perms_option = [];
            if (isset($user_perms) && $user_perms) {
                foreach ($user_perms as $key => $value) {
                    $perms_option[$key] = ucfirst($value);
                }
            }
            echo form_dropdown('perms[]', $perms_option, set_value('perms[]', $current_perms), 'data-placeholder="Select perms...." class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 multiple-select" multiple');
            ?>

            <div class="flex items-start mt-3">
                <button type="submit" name="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </div>

            <?php echo form_close(); ?>


        </div>
    </div>
</main>
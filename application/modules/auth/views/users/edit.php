<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Update User</h1>
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

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <?= form_open(uri_string(), 'class="w-full max-w-lg"'); ?>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">First name<span class="text-red-500">*</span>
                </label>
                <?php echo form_input($first_name); ?>
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Lastname <span class="text-red-500">*</span>
                </label>
                <?php echo form_input($last_name); ?>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Email <span class="text-red-500">*</span>
                </label>
                <?php echo form_input($email); ?>
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Phone
                </label>
                <?php echo form_input($phone); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h5 class="title">Login Information</h5>
            </div>
        </div>
        <!--./row -->

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Roles <span class="text-red-500">*</span>
                </label>
                <table class="text-sm font-normal">
                    <tr>
                        <?php
                        $serial = 0;
                        if (isset($groups) && $groups) {
                            foreach ($groups as $group) {
                                if (($serial % 1) == 0) {
                                    echo '</tr><tr>';
                                } ?>
                                <?php
                                $gID = $group->id;
                                $checked = null;
                                $item = null;
                                foreach ($currentGroups as $grp) {
                                    if ($gID == $grp->id) {
                                        $checked = ' checked="checked"';
                                        break;
                                    }
                                }
                                ?>
                                <td><span id="grp-<?= $group->id ?>">
                                        <input type="checkbox" name="groups_ids[]" value="<?php echo $group->id; ?>" <?php echo $checked; ?>>
                                        <?= $group->description; ?>&nbsp;&nbsp;&nbsp;</span>
                                </td>
                        <?php
                                $serial++;
                            }
                        } ?>
                        <span class="red"><?= form_error('groups_ids[]'); ?></span>
                    </tr>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Username <span class="text-red-500">*</span>
                </label>
                <?php echo form_input($identity); ?>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Password
                </label>
                <?php echo form_input($password); ?>
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 text-sm font-medium text-gray-900">Confirm Password
                </label>
                <?php echo form_input($password_confirm); ?>
            </div>
        </div>

        <div class="flex items-start">
            <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
        </div>


        <?= form_close(); ?>
    </div>
</main>
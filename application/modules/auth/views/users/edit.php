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

<main class="bg-white h-[calc(100%-9rem)] flex overflow-hidden relative">
    <div class="flex-1 h-full overflow-y-scroll">
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <?= form_open(uri_string(), 'class="w-full md:w-2/3"'); ?>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">First name<span class="text-red-500">*</span>
                    </label>
                    <?php echo form_input($first_name); ?>
                    <span class="text-red-500 text-xs"><?= form_error('first_name'); ?></span>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Lastname <span class="text-red-500">*</span>
                    </label>
                    <?php echo form_input($last_name); ?>
                    <span class="text-red-500 text-xs"><?= form_error('last_name'); ?></span>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Email <span class="text-red-500">*</span>
                    </label>
                    <?php echo form_input($email); ?>
                    <span class="text-red-500 text-xs"><?= form_error('email'); ?></span>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Phone
                    </label>
                    <?php echo form_input($phone); ?>
                    <span class="text-red-500 text-xs"><?= form_error('phone'); ?></span>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">District <span class="text-red-500">*</span>
                    </label>
                    <?php
                    $options = array();
                    foreach ($districts as $val) {
                        $options[$val->name] = $val->name;
                    }
                    $options = array('' => '-- Sélectionnez --') + $options;
                    echo form_dropdown('district', $options, set_value('district', $user->district), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"');
                    ?>
                    <div class="text-red-500 text-xs"><?php echo form_error('district'); ?></div>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Username <span class="text-red-500">*</span>
                    </label>
                    <?php echo form_input($identity); ?>
                    <span class="text-red-500 text-xs"><?= form_error('identity'); ?></span>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Password
                    </label>
                    <?php echo form_input($password); ?>
                    <span class="text-red-500 text-xs"><?= form_error('password'); ?></span>
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Confirm Password
                    </label>
                    <?php echo form_input($password_confirm); ?>
                    <span class="text-red-500 text-xs"><?= form_error('password_confirm'); ?></span>
                </div>
            </div>

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
                                    if (($serial % 2) == 0) {
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
                        </tr>
                    </table>
                    <span class="text-red-500 text-xs"><?= form_error('groups_ids[]'); ?></span>
                </div>
            </div>

            <div class="flex items-start">
                <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Modifier</button>
            </div>


            <?= form_close(); ?>
        </div>
    </div>
</main>
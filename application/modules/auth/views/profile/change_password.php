<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Change Password</h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="<?= site_url('auth/profile'); ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        My Profile
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url('auth/change_password'); ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Change Password
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

                    <div class="w-1/4">
                        <?php echo form_open('auth/change_password', 'role="form"'); ?>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                Old Password<span class="text-red-500">*</span>
                            </label>
                            <?php echo form_input($old_password); ?>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <?php echo form_input($new_password); ?>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                <?= $this->lang->line("change_password_new_password_confirm_label") ?> <span class="text-red-500">*</span>
                            </label>
                            <?php echo form_input($new_password_confirm); ?>
                        </div>

                        <div class="flex items-start">
                            <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Change</button>
                        </div>
                        <?php echo form_input($user_id); ?>
                        <?php echo form_close(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
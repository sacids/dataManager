<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Update Role</h1>
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
            <?= form_open(uri_string(), 'class="w-full md:w-1/2"'); ?>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-full px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Role Name<span class="text-red-500">*</span>
                    </label>
                    <?php echo form_input($group_name); ?>
                    <span class="text-red-500 text-xs"><?= form_error('group_name'); ?></span>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-full px-3 mb-6 md:mb-0">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Description<span class="text-red-500">*</span>
                    </label>
                    <?= form_textarea($group_description); ?>
                    <span class="text-red-500 text-xs"><?= form_error('group_description'); ?></span>
                </div>
            </div>

            <div class="flex items-start">
                <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Modifier</button>
            </div>

            <?= form_close(); ?>
        </div>
    </div>
</main>
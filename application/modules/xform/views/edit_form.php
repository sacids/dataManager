<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?> > Update Form - <?= $form->title ?>
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

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">

            <div class="flex w-1/2 flex-col">
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

                    <?php echo form_open_multipart(uri_string(), 'role="form"'); ?>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            <?php echo $this->lang->line("label_form_title") ?> <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title', $form->title); ?>" class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Write form title..." required>
                    </div>


                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            <?php echo $this->lang->line("label_description") ?> <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="3" class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Write description here..." required><?php echo set_value('description', $form->description); ?></textarea>

                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            <?php echo $this->lang->line("label_access") ?> <span class="text-red-500">*</span>
                        </label>

                        <select id="access" name="access" class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="<?= $form->access ?>"><?= ucfirst($form->access) ?></option>
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Push</label>
                        <?php
                        echo form_checkbox('push', 1, ($form->push == 1) ? TRUE : FALSE);
                        echo form_label('Yes', 'push'); ?>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Has Symptoms</label>
                        <?php
                        echo form_checkbox('has_symptoms_field', 1, ($form->has_symptoms_field == 1) ? TRUE : FALSE);
                        echo form_label('Yes', 'has_symptoms_field'); ?>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Has Specie</label>
                        <?php
                        echo form_checkbox('has_specie_type_field', 1, ($form->has_specie_type_field == 1) ? TRUE : FALSE);
                        echo form_label('Yes', 'has_specie_type_field'); ?>
                    </div>

                    <div class="flex items-start">
                        <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
        <!-- /End replace -->
    </div>
</main>
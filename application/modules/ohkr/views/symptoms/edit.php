<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            Edit symptom
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

                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label>
                                    <?php echo $this->lang->line("label_symptom_name"); ?> <span class="text-red-500"> * </span>
                                </label>
                                <input type="text" name="name" placeholder="Write symptom name..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo $symptom->title; ?>">
                                <div class="text-red-500"><?php echo form_error('name'); ?></div>
                            </div>

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <?php echo $this->lang->line("label_symptom_code"); ?> <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" placeholder="Write symptom code..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo $symptom->code; ?>">
                                <div class="text-red-500"><?php echo form_error('code'); ?></div>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-3">
                            <div class="w-full md:w-full px-3 mb-6 md:mb-0">
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    Photo
                                </label>
                                <input class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="photo" name="photo" type="file" accept="image/*">
                                <div class="text-red-500 text-xs"><?php echo form_error('photo'); ?></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                <?php echo $this->lang->line("label_description") ?> <span class="text-red-500">*</span>
                            </label>
                            <textarea class="form-control" name="description" id="description"><?php echo $symptom->description; ?></textarea>
                            <script>
                                CKEDITOR.replace('description');
                            </script>
                            <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                        </div>

                        <div class="flex items-start">
                            <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Modifier</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= $disease->title; ?> : Add Clinical Manifestation
        </h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <?php
            foreach ($page_links as $key => $link) {
                echo $link;
            }
            ?>
        </div>
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

                    <?= form_open(uri_string(), 'role="form"'); ?>
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label>
                                <?php echo $this->lang->line("label_symptom_name"); ?> <span class="text-red-500"> * </span>
                            </label>
                            <?php
                            $symptoms_options = array();
                            foreach ($symptoms as $value) {
                                $symptoms_options[$value->id] = $value->code . '. ' . $value->title;
                            }
                            $symptoms_options = array('' => '-- Select --') + $symptoms_options;
                            echo form_dropdown('symptom_id', $symptoms_options, set_value('symptom_id', $disease_symptom->symptom_id), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"');
                            ?>
                            <div class="text-red-500"><?php echo form_error('symptom_id'); ?></div>
                        </div>

                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Importance (%) <span class="text-red-500">*</span></label>
                        <?= form_input($importance); ?>
                        <div class="text-red-500"><?php echo form_error('importance'); ?></div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Modifier</button>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>
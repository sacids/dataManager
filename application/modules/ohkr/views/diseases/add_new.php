<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
        Add new disease
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

                    <?php echo form_open('ohkr/add_new_disease', 'role="form"'); ?>

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label>
                                <?php echo $this->lang->line("label_disease_name") ?> <span class="text-red-500"> * </span>
                            </label>
                            <input type="text" name="name" placeholder="Write disease name..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo set_value('name'); ?>">
                            <div class="text-red-500"><?php echo form_error('name'); ?></div>
                        </div>

                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                            <?php echo $this->lang->line("label_specie_name") ?> <span class="text-red-500">*</span>
                            </label>
                            <?php
                                $species_options = [];
                                foreach ($species as $specie) {
                                    $species_options[$specie->id] = $specie->title;
                                }
                                $species_options = ['' => '--Select--'] + $species_options;
                                echo form_dropdown("specie", $species_options, set_value("specie"), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"')
                                ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            <?php echo $this->lang->line("label_description") ?> <span class="text-red-500">*</span>
                        </label>
                        <textarea class="form-control" name="description" id="description"><?php echo set_value('description'); ?></textarea>
                        <script>
                            CKEDITOR.replace('description');
                        </script>
                        <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                    </div>

                    <div class="flex items-start">
                        <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Soumettre</button>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>
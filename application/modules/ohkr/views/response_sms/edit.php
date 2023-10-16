<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
        Ajouter une nouvelle réponse SMS pour la maladie</h3>
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

            <div class="flex flex-wrap mb-4 x-space-2">
                <div class="w-full md:w-1/2">
                    <div class="w-full bg-gray-100 py-3 px-3">
                        <?= form_open('ohkr/edit_response_sms/' . $message->id, 'role="form"'); ?>

                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label>
                                    <?php echo $this->lang->line("label_recipient_group"); ?> <span class="text-red-500"> * </span>
                                </label>
                                <?php
                                $groupOptions = array();
                                foreach ($groups as $group) {
                                    $groupOptions[$group->id] = $group->name;
                                }
                                $groupOptions = array('' => '-- Sélectionnez --') + $groupOptions;
                                echo form_dropdown('group', $groupOptions, set_value('group', $message->group_id), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"');
                                ?>
                                <div class="text-red-500 text-xs"><?php echo form_error('group'); ?></div>
                            </div>

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label>
                                    <?php echo $this->lang->line("label_status"); ?> <span class="text-red-500"> * </span>
                                </label>
                                <?php
                                $statusOptions = array("" => "-- Sélectionnez --", "Enabled" => "Activé", "Disabled" => "Désactivé");
                                echo form_dropdown('status', $statusOptions, set_value('status', $message->status), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"');
                                ?>
                                <div class="text-red-500 text-xs"><?php echo form_error('status'); ?></div>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full md:w-full px-3 mb-6 md:mb-0">
                                <label class="block mb-2 text-sm font-medium text-gray-900"><?php echo $this->lang->line("label_alert_message") ?> <span class="text-red-500">*</span></label>
                                <textarea class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="message" rows="5" id="message"><?php echo set_value('message', $message->message); ?></textarea>
                                <div class="text-red-500 text-xs"><?php echo form_error('message'); ?></div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <button type="submit" name="save" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Soumettre</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

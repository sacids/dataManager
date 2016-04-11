<div class="grid_11" style="padding-top: 20px; text-align: left;">
    <?php echo form_open_multipart('campaign/add_new', 'class="pure-form pure-form-aligned"'); ?>
    <div class="formCon">
        <div class="formConInner">
            <h3>Campaign Details</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <fieldset>
                <div class="pure-control-group">
                    <label>Campaign Title <span>*</span></label>
                    <input type="text" name="title" placeholder="Enter Campaign Title" class="pure-input-1-2"
                           value="<?php echo set_value('title'); ?>">
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('title'); ?></div>

                <div class="pure-control-group">
                    <label>Campaign Icon <span>*</span></label>
                    <input type="text" name="icon" placeholder="Enter campaign icon" class="pure-input-1-2"
                           value="<?php echo set_value('icon'); ?>">
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('icon'); ?></div>


                <div class="pure-control-group">
                    <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label>
                        <textarea class="pure-input-1-2" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('description'); ?></div>

                <div class="pure-control-group">
                    <label for="campus">Form Id :</label>
                    <select name="form_id" id="form_id" class="pure-input-1-2">
                        <option value="">Choose form</option>
                        <?php foreach($forms as $form){?>
                        <option value="<?php echo $form->form_id?>"><?php echo $form->form_id?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('form_id'); ?></div>

                <div class="pure-control-group">
                    <label>&nbsp; &nbsp; &nbsp;</label>
                    <button type="submit" class="pure-button pure-button-primary">Save</button>
                </div>

            </fieldset>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div style="clear: both;"></div>


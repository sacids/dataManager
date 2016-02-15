<div class="grid_11" style="padding-top: 20px; text-align: left;">
    <?php echo form_open_multipart('xform/add_new', 'class="pure-form pure-form-aligned"'); ?>
    <div class="formCon">
        <div class="formConInner">
            <h3>Form Details</h3>
            <?php
            if ($this->session->flashdata('message') != ''):
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            endif; ?>

            <fieldset>
                <div class="pure-control-group">
                    <label>Form title <span>*</span></label>
                    <input type="text" name="title" placeholder="Enter Form Title" class="pure-input-1-2"
                           value="<?php echo set_value('title'); ?>">
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('title'); ?></div>

                <div class="pure-control-group">
                    <label>Form ID <span>*</span></label>
                    <input type="text" name="form_id" placeholder="Enter Form ID"
                           value="<?php echo set_value('form_id'); ?>" class="pure-input-1-2">
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('form_id'); ?></div>

                <div class="pure-control-group">
                    <label for="">Form XML File <span>*</span></label>
                    <?= form_upload("userfile") ?>
                </div>


                <div class="pure-control-group">
                    <label> <label for="campus">Description:</label> </label>
                        <textarea class="pure-input-1-2" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('description'); ?></div>

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
</div>            </div>
</div>

<div class="grid_11" style="padding-top: 20px; text-align: left;">
    <?php echo form_open_multipart('ohkr/add_disease_symptom/'.$disease->id, 'class="pure-form pure-form-aligned"'); ?>
    <div class="formCon">
        <div class="formConInner">
            <h3><?php echo $disease->name;?> Disease Symptom</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>
            <fieldset>

                <div class="pure-control-group">
                    <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                    <select name="specie" id="specie" class="pure-input-1-2">
                        <option value="">Choose Specie</option>
                        <?php foreach($species as $specie){ ?>
                            <option value="<?php echo $specie->id;?>"><?php echo $specie->name;?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('specie'); ?></div>

                <div class="pure-control-group">
                    <label><?php echo $this->lang->line("label_symptom_name") ?> <span>*</span></label>
                    <select name="symptom" id="symptom" class="pure-input-1-2">
                        <option value="">Choose Symptom</option>
                        <?php foreach($symptoms as $symptom){ ?>
                            <option value="<?php echo $symptom->id;?>"><?php echo $symptom->name;?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('symptom'); ?></div>

                <div class="pure-control-group">
                    <label>Importance (%) <span>*</span></label>
                    <input type="text" name="importance" placeholder="Enter importance" class="pure-input-1-2" value="<?php echo set_value('importance'); ?>">
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('importance'); ?></div>


                <div class="pure-control-group">
                    <label>&nbsp; &nbsp; &nbsp;</label>
                    <button type="submit" class="pure-button pure-button-primary">Save</button>
                </div>
            </fieldset>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

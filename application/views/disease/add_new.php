<div class="grid_11" style="padding-top: 20px; text-align: left;">
	<?php echo form_open_multipart('disease/add_new', 'class="pure-form pure-form-aligned"'); ?>
	<div class="formCon">
		<div class="formConInner">
			<h3>Disease Details</h3>
			<?php
			if ($this->session->flashdata('message') != '') {
				echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
			} ?>

			<fieldset>
				<div class="pure-control-group">
					<label><?php echo $this->lang->line("label_disease_name") ?> <span>*</span></label>
					<input type="text" name="name" placeholder="Enter disease name" class="pure-input-1-2"
					       value="<?php echo set_value('name'); ?>">
				</div>
				<div class="pure-form-message-inline"><?php echo form_error('name'); ?></div>

				<!--div class="pure-control-group">
					<label><?php echo $this->lang->line("label_specie") ?> <span>*</span></label>

					<?php //echo form_dropdown("specie", $species, set_value('specie', ''), 'class="pure-input-1-2"'); ?>
				</div=-->

				<div class="pure-form-message-inline"><?php echo form_error('specie'); ?></div>

				<div class="pure-control-group">
					<label> <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label> </label>
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

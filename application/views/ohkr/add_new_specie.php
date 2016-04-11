<div class="grid_11" style="padding-top: 20px; text-align: left;">
	<?php echo form_open_multipart('ohkr/add_new_specie', 'class="pure-form pure-form-aligned"'); ?>
	<div class="formCon">
		<div class="formConInner">
			<h3>Disease Details</h3>
			<?php
			if ($this->session->flashdata('message') != '') {
				echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
			} ?>

			<fieldset>
				<div class="pure-control-group">
					<label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
					<input type="text" name="specie" placeholder="Enter disease name" class="pure-input-1-2"
					       value="<?php echo set_value('specie'); ?>">
				</div>
				<div class="pure-form-message-inline"><?php echo form_error('specie'); ?></div>

				<div class="pure-control-group">
					<label>&nbsp; &nbsp; &nbsp;</label>
					<button type="submit" class="pure-button pure-button-primary">Save</button>
				</div>

			</fieldset>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>

<div class="grid_11" style="padding-top: 20px; text-align: left;">
	<?php echo form_open_multipart('xform/edit_form/' . $form->id, 'class="pure-form pure-form-aligned"'); ?>
	<div class="formCon">
		<div class="formConInner">
			<h3>Form Details</h3>
			<?php
			if ($this->session->flashdata('message') != '') {
				echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
			} ?>

			<fieldset>
				<div class="pure-control-group">
					<label><?php echo $this->lang->line("label_form_title")?> <span>*</span></label>
					<input type="text" name="title" placeholder="Enter Form Title" class="pure-input-1-2"
					       value="<?php echo set_value('title', $form->title); ?>">
				</div>
				<div class="pure-form-message-inline"><?php echo form_error('title'); ?></div>

				<div class="pure-control-group">
					<label> <label for="campus"><?php echo $this->lang->line("label_description") ?>:</label> </label>
                        <textarea class="pure-input-1-2" name="description"
                                  id="description"><?php echo set_value('description', $form->description); ?></textarea>
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

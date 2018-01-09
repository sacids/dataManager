<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">

			<h1><?php echo lang('change_password_heading'); ?></h1>

			<div id="infoMessage"><?php echo $message; ?></div>

			<?php echo form_open("auth/change_password", 'class="form-horizontal" role="form"'); ?>

			<div class="form-group">
				<label><?php echo lang('change_password_old_password_label', 'old_password'); ?></label>
				<?php echo form_input($old_password, "", "class='form-control'"); ?>
			</div>

			<div class="form-group">
				<label for="new_password">
					<?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?>
				</label>
				<?php echo form_input($new_password, "", "class='form-control'"); ?>
			</div>

			<div class="form-group">
				<?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?> <br/>
				<?php echo form_input($new_password_confirm, "", "class='form-control'"); ?>
			</div>

			<?php echo form_input($user_id); ?>
			<div class="form-group">
				<?php echo form_submit('submit', lang('change_password_submit_btn', "", "class='btn btn-primary'")); ?>
			</div>

			<?php echo form_close(); ?>
		</div>
	</div>
</div>
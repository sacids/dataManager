<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">
			<?php echo form_open('auth/change_password', 'class="form-horizontal" role="form"') ?>

			<h3>Fill information to change password</h3>

			<fieldset>
				<div class="form-group">
					<label>  <?php echo lang('change_password_old_password_label', 'old_password'); ?></label>
					<?php echo form_input($old_password,"", 'class="form-control"'); ?>
				</div>
				<?php echo form_error('old'); ?>

				<div class="form-group">
					<label> <?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?></label>
					<?php echo form_input($new_password,"", 'class="form-control"'); ?>
				</div>
				<?php echo form_error('new'); ?>

				<div class="form-group">
					<label> <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?> </label>
					<?php echo form_input($new_password_confirm,"", 'class="form-control"'); ?>
				</div>
				<?php echo form_error('new_confirm'); ?>

				<?php echo form_input($user_id); ?>
				<div class="form-group">
					<input type="submit" value="Change Password" class="btn btn-primary"/>
			</fieldset>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
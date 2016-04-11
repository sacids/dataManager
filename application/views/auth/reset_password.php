<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">

			<h1><?php echo lang('reset_password_heading'); ?></h1>

			<div id="infoMessage"><?php echo $message; ?></div>

			<?php echo form_open('auth/reset_password/' . $code, 'class="form-horizontal" role="form"'); ?>

			<div class="form-group">
				<label for="new_password">
					<?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label>
				<?php echo form_input($new_password); ?>
			</div>

			<div class="form-group">
				<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?> <br/>
				<?php echo form_input($new_password_confirm); ?>
			</div>

			<?php echo form_input($user_id); ?>
			<?php echo form_hidden($csrf); ?>

			<p><?php echo form_submit('submit', lang('reset_password_submit_btn'), "class='btn btn-primary'"); ?></p>

			<?php echo form_close(); ?>
		</div>
	</div>
</div>


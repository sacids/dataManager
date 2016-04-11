<div class="container-fluid"">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">

			<?php echo form_open(uri_string(), 'class="form-horizontal" role="form"') ?>

			<h3>Edit User Account</h3>
			<?php
			if ($this->session->flashdata('message') != ''):
				echo display_message($this->session->flashdata('message'));
			elseif (isset($error_in)):
				echo display_message($error_in, "danger");
			endif; ?>

			<fieldset style="width: 90%;">
				<legend>Basic User Information</legend>
				<div class="form-group">
					<label> <label for="first_name">First Name:<span>*</span></label> </label>
					<?php echo form_input($first_name,"","class='form-control'"); ?>
				</div>
				<?php echo form_error('first_name'); ?>

				<div class="form-group">
					<label> <label for="last_name">Last Name:<span>*</span></label> </label>
					<?php echo form_input($last_name,"","class='form-control'"); ?>
				</div>
				<?php echo form_error('last_name'); ?>

				<div class="form-group">
					<label> <label for="email">Email:</label> </label>
					<?php echo form_input($email,"","class='form-control'"); ?>
				</div>
				<?php echo form_error('email'); ?>

				<div class="form-group">
					<label> <label for="phone">Phone:<span>*</span></label> </label>
					<?php echo form_input($phone,"","class='form-control'"); ?>
				</div>
				<?php echo form_error('phone'); ?>
			</fieldset>

			<fieldset style="width: 90%;">
				<legend>Account User</legend>

				<div class="checkbox">
					<label> <label for="group">Group:<span>*</span></label> </label>
					<?php foreach ($groups as $group): ?>
						<?php
						$gID = $group['id'];
						$checked = NULL;
						$item = NULL;
						foreach ($currentGroups as $grp) {
							if ($gID == $grp->id) {
								$checked = ' checked="checked"';
								break;
							}
						}
						?>
						<label></label><input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?> >
						<?php echo $group['name']; ?></label>
					<?php endforeach ?>
				</div>
				<?php echo form_error('group'); ?>

				<div class="form-group">
					<label> <label for="password">Password:<br/>
							<small>(if changing password)</small>
						</label> </label>
					<?php echo form_input($password,"","class='form-control'"); ?>
				</div>
				<?php echo form_error('password'); ?>

				<div class="form-group">
					<label> <label for="password_confirm">Confirm Password:<br/>
							<small>(if changing password)</small>
						</label> </label>
					<?php echo form_input($password_confirm,"","class='form-control'"); ?>
				</div>

				<?php echo form_hidden('id', $user->id); ?>
				<?php echo form_hidden($csrf); ?>

				<div class="form-group">
					<button type="submit" class="btn btn-primary">Edit User</button>
				</div>
			</fieldset>


		</div>
	</div>

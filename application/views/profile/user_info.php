<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">
			<h3><?php echo $title; ?></h3>

			<div class="col-sm-3 col-md-3 col-lg-3">
				<div id="header-title" style="" class="text-center">
					<div style="width: auto; float: left; display: inline-block;">
						<img src="<?php echo base_url(); ?>assets/public/images/profile.png"/>
						<h1><?php echo $fname; ?></h1>
					</div>
					<?php //$this->load->view('subheader'); ?>
					<div style="clear: both;"></div>
				</div>
			</div>
			<div class="col-sm-9 col-md-9 col-lg-9">
				<div class="table table-responsive">

					<table class="table" cellspacing="0" cellpadding="0">
						<tr>
							<td>Name</td>
							<td><?php echo $fname; ?></td>
						</tr>
						<tr>
							<td>Username</td>
							<td><?php echo $username; ?></td>
						</tr>

						<tr>
							<td>Phone</td>
							<td><?php echo $phone; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $email; ?></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td><?php echo $phone; ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php
								if ($status == '1') {
									echo 'Active';
								} else {
									echo 'Inactive';
								}
								?></td>
						</tr>
						<tr>
							<td>Created on</td>
							<td><?php echo $created; ?></td>
						</tr>
						<tr>
							<td>Last Login</td>
							<td><?php echo $last_login; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

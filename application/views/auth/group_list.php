<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">

			<div class="table table-responsive tab-content table-bordered table-condensed">

				<table class="table" cellspacing="0" cellpadding="0">
					<tr>
						<th>S/n</th>
						<th>Group Name</th>
						<th>Group Description</th>
						<th>Action</th>
						</th>
					</tr>
					<?php
					$serial = 1;
					foreach ($groups as $values):?>
						<tr>
							<td><?php echo $serial; ?></td>
							<td><?php echo $values->name; ?></td>
							<td><?php echo $values->description; ?></td>
							<td>
								<a href="<?php echo base_url(); ?>index.php/auth/edit_group/<?php echo $values->id; ?>"
								   title="Edit">Edit</a>
							</td>
						</tr>
						<?php
						$serial++;
					endforeach; ?>
				</table>

			</div>
		</div>
	</div>
</div>

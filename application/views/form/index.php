<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">

			<?php
			if ($this->session->flashdata('message') != '') {
				echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
			}
			?>

			<div class="">

				<?php if (!empty($forms)) { ?>

					<table class="table table-striped table-responsive table-hover table-bordered" cellspacing="0"
					       cellpadding="0">
						<tr>
							<th><?php echo $this->lang->line("label_form_name"); ?></th>
							<!--								<th>-->
							<?php //echo $this->lang->line("label_form_id"); ?><!--</th>-->
							<th><?php echo $this->lang->line("label_description"); ?></th>
							<!--								<th>-->
							<?php //echo $this->lang->line("label_xml"); ?><!--</th>-->
							<th><?php echo $this->lang->line("label_date_created"); ?></th>
							<th colspan="3" class="text-center"><?php echo $this->lang->line("label_action"); ?></th>
						</tr>

						<?php
						$serial = 1;
						foreach ($forms as $form) { ?>
							<tr>
								<td><?php echo $form->title; ?></td>
								<!--									<td>-->
								<?php //echo anchor("xform/form_data/" . $form->id, $form->form_id); ?><!--</td>-->
								<td><?php echo $form->description; ?></td>
								<td><?php echo date('d-m-Y H:i:s', strtotime($form->date_created)); ?></td>
								<!--									<td>-->
								<?php //echo anchor_popup(base_url() . "assets/forms/definition/" . $form->filename, $form->filename); ?><!--</td>-->
								<td>
									<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button"
										        data-toggle="dropdown">View <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><?php echo anchor("xform/form_data/" . $form->id, "Data list"); ?></li>
											<li><?php echo anchor("form_visualization/chart/" . $form->form_id, "View Chart"); ?></li>
											<li><?php echo anchor("form_visualization/map/" . $form->form_id, "View Map"); ?></li>
										</ul>
									</div>
								</td>
								<td>
									<?php echo anchor("xform/edit_form/" . $form->id, "Edit"); ?>
								</td>
								<td>
									<?php echo anchor("xform/delete_xform/" . $form->id, "Delete", "class='delete'"); ?>
								</td>
							</tr>
							<?php $serial++;
						} ?>
					</table>

				<?php } else { ?>
					<div class="fail_message">You don't have any form to display</div>
				<?php } ?>
			</div>

		</div>
	</div>
</div>
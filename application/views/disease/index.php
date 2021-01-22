<div id="grid_padding" class="grid_11">

	<?php
	if ($this->session->flashdata('message') != '') {
		echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
	} ?>

	<div class="table_list">

		<?php if (!empty($diseases)) { ?>

			<table class="table" cellspacing="0" cellpadding="0">
				<tr>
					<th><?php echo $this->lang->line("label_disease_name"); ?></th>
					<th><?php echo $this->lang->line("label_description"); ?></th>
					<th><?php echo $this->lang->line("label_date_created"); ?></th>
					<th><?php echo $this->lang->line("label_action"); ?></th>
				</tr>

				<?php
				$serial = 1;
				foreach ($diseases as $disease) { ?>
					<tr>
						<td><?php echo $disease->name; ?></td>
						<td><?php echo $disease->description; ?></td>
						<td><?php echo date('d-m-Y H:i:s', strtotime($disease->date_created)); ?></td>
						<td>
							<?php echo anchor("disease/edit_disease/" . $disease->id, "Edit"); ?>
							<?php echo anchor("disease/delete_disease/" . $disease->id, "Delete", "class='delete'"); ?>
						</td>
					</tr>
					<?php $serial++;
				} ?>
			</table>

		<?php } else { ?>
			<div class="fail_message">No disease has been added</div>
		<?php } ?>
	</div>
</div>

<div id="grid_padding" class="grid_11">

	<?php
	if ($this->session->flashdata('message') != '') {
		echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
	} ?>

	<div class="table_list">
		<table class="table" cellspacing="0" cellpadding="0">
			<tr>
				<th><?php echo $this->lang->line("label_form_name");?></th>
				<th><?php echo $this->lang->line("label_form_id");?></th>
				<th><?php echo $this->lang->line("label_date_created");?></th>
				<th><?php echo $this->lang->line("label_description");?></th>
				<th><?php echo $this->lang->line("label_xml");?></th>
				<th><?php echo $this->lang->line("label_action");?></th>
			</tr>

			<?php
			$serial = 1;
			foreach ($forms as $form) { ?>
				<tr>
					<td><?php echo $form->title; ?></td>
					<td><?php echo $form->form_id; ?></td>
					<td><?php echo date('d-m-Y H:i:s', strtotime($form->date_created)); ?></td>
					<td><?php echo $form->description; ?></td>
					<td><?php echo anchor_popup(base_url() . "assets/forms/definition/" . $form->filename, $form->filename); ?></td>
					<td>
						<?php echo anchor("xform/edit_form/" . $form->id, "Edit"); ?>
						<?php echo anchor("xform/delete_xform/" . $form->id, "Delete", "class='delete'"); ?>
					</td>
				</tr>
				<?php $serial++;
			} ?>
		</table>

	</div>
</div>
<div style="clear: both;"></div>
</div>            </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/24/2016
 * Time: 7:09 PM
 */

?>
<div class="grid_11">
	<h3>Uploaded form data</h3>
	<?php
	if ($this->session->flashdata('message') != '') {
		echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
	}
	?>

	<div class="table_list">
		<table class="table">

			<tr>

				<?php
				foreach ($table_fields as $key => $column) {
					echo "<th>" . $column . "</th>";
				}
				?>
			</tr>

			<?php
			foreach ($form_data as $data) {

				echo "<tr>";
				foreach ($data as $key => $entry) {
					echo "<td>" . $entry . "</td>";
				}
				echo "</tr>";

			}
			?>

		</table>

	</div>
</div>
<?php echo form_close(); ?>
</div>
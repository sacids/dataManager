<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/24/2016
 * Time: 7:09 PM
 */

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 main">

			<h3>Form data collected</h3>
			<?php
			if ($this->session->flashdata('message') != '') {
				echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
			}
			?>
			<table class="table table_list table-bordered table-striped table-hover table-condensed">
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

						if (preg_match('/(\.jpg|\.png|\.bmp)$/', $entry)) {
							echo "<td><img src=' " . base_url() . "assets/forms/data/images/" . $entry . "' style='max-width:100px;' /></td>";
						} else {
							echo "<td>" . $entry . "</td>";
						}

					}
					echo "</tr>";
				}
				?>
			</table>
		</div>
	</div>
</div>
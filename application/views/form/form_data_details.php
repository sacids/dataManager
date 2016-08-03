<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/24/2016
 * Time: 7:09 PM
 */

?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div class="row" style="margin-bottom: 10px;">
                <h3>Form data collected</h3>
			<span class="pull-right">
				<?php echo anchor("xform/csv_export_form_data/" . $form_id, '<img src="' . base_url() . 'assets/public/images/csv-export.png" height="30px"/>') ?>
                <?php echo anchor("xform/xml_export_form_data/" . $form_id, '<img src="' . base_url() . 'assets/public/images/xml-export.png" height="30px"/>') ?>
			</span>
            </div>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            }
            ?>
            <table class="table table_list table-bordered table-striped table-hover table-condensed">
                <tr>
                    <?php
                    foreach ($table_fields as $key => $column) {
                        if (array_key_exists($column, $field_maps)) {
                            echo "<th>" . $field_maps[$column] . "</th>";
                        } else {
                            echo "<th>" . $column . "</th>";
                        }
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
            <?php if (!empty($links)): ?>
                <div class="widget-foot">
                    <?= $links ?>
                    <div class="clearfix"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
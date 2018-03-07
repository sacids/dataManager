<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 2/24/2016
 * Time: 7:09 PM
 */

?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select data filtering fields</h4>
            </div>
            <div class="modal-body">

                <?php echo form_open("xform/form_data/" . $form->id, 'class="form-horizontal" role="form"') ?>

                <?php
                foreach ($mapped_fields as $key => $value) {
                    echo '<div class="checkbox"><label>';
                    echo form_checkbox($key, $value) . $value . "</label></div>";
                }
                ?>

                <input type="submit" name="apply" value="Apply filters" class="btn btn-primary col-lg-offset-1"/>

                <?php echo form_close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="container body-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $title ?> - Form data collected</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active"><?= $title ?></li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <!--<div class="pull-left">
                        <?php echo form_open(uri_string(), 'class="form-inline" role="form"'); ?>
                        <div class="form-group">
                            <?php
                    $week_options = array();
                    for ($i = 1; $i <= 52; $i++) {
                        $week_options[$i] = $i;
                    }
                    $week_options = array('' => 'Week Number') + $week_options;
                    echo form_dropdown('week', $week_options, set_value('week'), 'class="form-control"'); ?>
                        </div>

                        <div class="form-group">
                            <?php echo form_submit("export", "Export", 'class="btn btn-primary"'); ?>
                        </div>
                        <?php echo form_close(); ?>
                    </div>-->

                    <div class="pull-right">
                        <button type="button" class="btn btn-link" data-toggle="modal"
                                data-target="#myModal">Set Filters
                        </button>
                        <?php echo anchor("xform/excel_export_form_data/" . $form_id, '<i class="fa fa-file-excel-o fa-lg"></i>&nbsp;&nbsp;', 'title="Export XLS"') ?>
                        <?php echo anchor("visualization/visualization/chart/" . $form_id, '<i class="fa fa-bar-chart-o fa-lg"></i>&nbsp;&nbsp;', 'title="Visualization"') ?>
                        <?php echo anchor("visualization/visualization/map/" . $form_id, '<i class="fa fa-map-marker fa-lg"></i>', 'title="View Map"') ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo get_flashdata();
                    echo validation_errors();
                    ?>
                </div>
            </div>

            <div style="overflow-x: scroll;">
                <?php echo form_open("xform/delete_entry/" . $form->id, array("class" => "form-horizontal", "role" => "form")); ?>
                <?php echo form_hidden("table_name", $form_id); ?>

                <table class="table table_list table-bordered table-striped table-hover table-condensed">
                    <tr>
                        <?php
                        echo "<th class='text-center'>Select All<br/>" . form_checkbox(array("id" => "selectAll")) . "</th>";

                        if (isset($selected_columns)) {
                            foreach ($selected_columns as $column) {
                                echo "<th>" . $column . "</th>";
                            }
                        } else {
                            foreach ($mapped_fields as $key => $column) {
                                if (array_key_exists($column, $field_maps)) {
                                    echo "<th>" . $field_maps[$column] . "</th>";
                                } else {
                                    echo "<th>" . $column . "</th>";
                                }
                            }
                        }
                        ?>
                    </tr>

                    <?php
                    foreach ($form_data as $data) {

                        echo "<tr>";
                        foreach ($data as $key => $entry) {

                            if ($key == "id") {
                                echo "<td class='text-center'>" . form_checkbox("entry_id[]", $entry) . "</td>";
                            }

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
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="submit" name="delete" value="Delete Selected" class="btn btn-danger delete">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <?php if (!empty($links)): ?>
                <div class="widget-foot">
                    <?= $links ?>
                    <div class="clearfix"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#selectAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $(function () {
        var imageTitle;
        var showModal = function () {

            imageTitle = $(this).closest('tr').find('td:eq(5)').text();

            var $input = $(this);
            var imgAlt = $input.attr("alt");
            $("#theModal h4.modal-title").html(imgAlt);
            var img = this;
            var imageHeight = $input.height();
            var imagWidth = $input.width();
            var NewimgWidth = imagWidth * 6;
            var NewImgHeight = imageHeight * 6;
            var picSrc = $input.attr("src");
            $("#theModal img").attr('src', picSrc);
            //set new image width
            $("div.modal-dialog").css("width", NewimgWidth);
            $("#theModal img").width(NewimgWidth);
            //set new image height
            $("#theModal img").height(NewImgHeight);
            $("#theModal").modal("show");
        };
        var MyHtml = '<div id="theModal" class="modal fade">' +
            ' <div class="modal-dialog ">' +
            '<div class="modal-content">' +
            ' <div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '<h4 class="modal-title">' + imageTitle + '</h4>' +
            '</div>' +
            '<div class="modal-body">' +
            '  <img not-to-enlarge="true" class="img-responsive" + src=""alt="...">' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-default" data-dismiss="modal">' +
            'Close' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $("div.body-content").append(MyHtml);
        $("img[not-to-enlarge!=true]").click(showModal);
        $("img[not-to-enlarge!=true]").css("cursor", "pointer");
    });

    $("img[not-to-enlarge!=true]").click(showModal);
    $("img[not-to-enlarge!=true]").css("cursor", "pointer");
</script>
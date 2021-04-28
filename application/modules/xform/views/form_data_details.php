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
                <h4 class="modal-title">SELECT DATA FILTERING FIELDS</h4>
            </div>
            <div class="modal-body">
                <?= form_open(uri_string(), 'class="form-horizontal" role="form"') ?>
                <div class="row">
                    <div class="col-lg-offset-1 col-sm-11">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?php
                                    foreach ($mapped_fields as $key => $value) {
                                        echo '<div class="checkbox"><label>';
                                        echo form_checkbox($key, $value) . $value . "</label></div>";
                                    }
                                    ?>
                                </div><!-- .end of form-group -->
                            </div>
                        </div><!-- /.row -->

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <?= form_submit('apply', 'Apply Filters', array('class' => "btn btn-primary")); ?>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                </div><!-- .end of form-group -->
                            </div>
                        </div> <!-- /.row -->
                    </div>
                </div><!-- ./row -->
                <?= form_close(); ?>
            </div><!-- ./modal-body -->
        </div>
    </div>
</div>

<div class="container body-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $project->title . ' : ' . $title ?> data collected</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projects</a></li>
                <li><a href="<?= site_url('projects/forms/' . $project->id) ?>"><?= $project->title ?></a></li>
                <li class="active"><?= $title ?></li>
            </ol>

            <div class="row">
                <div class="col-md-12">
                    <div class="pure-form">
                        <?php echo form_open(uri_string(), 'class="form-inlin" role="form"'); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_input(array('name' => 'start_at', 'id' => 'start_at', 'class' => "form-control", 'type' => 'date')); ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-4 -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_input(array('name' => 'end_at', 'id' => 'end_at', 'class' => "form-control", 'type' => 'date')); ?>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-4 -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-primary" style="width: 100px !important;">
                                        <i class="fa fa-search"></i> Filter
                                    </button>
                                </div>
                                <!--./form-group -->
                            </div>
                            <!--./col-md-4 -->
                        </div>
                        <!--./row-->
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">Set Filters
                        </button>
                        <?php echo anchor("xform/xls_export_form_data/" . $form_id, '<i class="fa fa-file-excel-o fa-lg"></i>&nbsp;&nbsp;', 'title="Export XLS"') ?>
                        <?php echo anchor("visualization/visualization/chart/" . $project->id . '/' . $form->id, '<i class="fa fa-bar-chart-o fa-lg"></i>&nbsp;&nbsp;', 'title="Visualization"') ?>
                        <?php echo anchor("visualization/visualization/map/" . $project->id . '/' . $form->id, '<i class="fa fa-map-marker fa-lg"></i>', 'title="View Map"') ?>
                    </div>
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo get_flashdata();
                    echo validation_errors();
                    ?>
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

            <?php if (isset($form_data) && $form_data) { ?>

                <?= form_open("xform/delete_entry/" . $project->id . '/' . $form->id, array("class" => "form-horizontal", "role" => "form")); ?>
                <?= form_hidden("table_name", $form_id); ?>
                <div style="overflow-x: scroll;">
                    <table class="table table_list table-bordered table-striped table-hover">
                        <tr style="position: sticky; top: 0;">
                            <?php
                            echo "<th class='text-center'>" . form_checkbox(array("id" => "selectAll")) . "</th>";

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

                                if ($key == "meta_instanceID") {
                                    echo '<td><a href="' . site_url('feedback/user_feedback/' . $entry) . '"><b>' . $entry . '</b></a></td>';
                                } else {
                                    if ($key == "meta_username") {
                                        echo "<td>" . get_collector_name_from_phone($entry) . '<br />' . $entry . "</td>";
                                    } else {
                                        if (preg_match('/(\.jpg|\.png|\.bmp)$/', $entry)) {
                                            echo "<td><img src=' " . base_url() . "assets/forms/data/images/" . $entry . "' style='max-width:100px;' /></td>";
                                        } else {
                                            echo "<td>" . $entry . "</td>";
                                        }
                                    }
                                }
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
                <!--./div -->

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <input type="submit" name="delete" value="Delete Selected" class="btn btn-danger delete">
                    </div>
                </div>
                <?= form_close(); ?>

                <?php if (!empty($links)) : ?>
                    <div class="widget-foot">
                        <?= $links ?>
                        <div class="clearfix"></div>
                    </div>
                <?php endif; ?>
            <?php } else {
                echo "<div class='alert alert-danger'>No any form data</div>";
            } ?>
        </div>
        <!--./col-md-12 -->
    </div>
    <!--./row -->
</div>
<!--./container -->

<script type="text/javascript">
    $("#selectAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $(function() {
        var imageTitle;
        var showModal = function() {

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
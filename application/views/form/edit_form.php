<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div id="header-title">
                <h3 class="title">Edit form</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Edit form</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            }
            ?>
            <?php echo form_open_multipart('xform/edit_form/' . $form->id, 'class="form-vertical" role="form"'); ?>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#form-details">Edit form details</a></li>
                <li><a data-toggle="tab" href="#access-permissions">Manage Access Permissions</a></li>
                <li><a data-toggle="tab" href="#map-columns"><?php echo "Map columns" ?></a></li>
            </ul>

            <div class="tab-content">
                <br/>
                <div id="form-details" class="tab-pane fade in active">
                    <div class="">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="">Edit form details</h3>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <?php echo form_label($this->lang->line("label_form_title"), " <span>*</span>"); ?>
                                    <input type="text" name="title" placeholder="Enter form title"
                                           class="form-control"
                                           value="<?php echo set_value('title', $form->title); ?>">
                                </div>
                                <div class=""><?php echo form_error('title'); ?></div>

                                <div class="form-group">
                                    <label for="campus"><?php echo $this->lang->line("label_description") ?>:</label>
                        <textarea class="form-control" name="description" rows="5"
                                  id="description"><?php echo set_value('description', $form->description); ?></textarea>
                                </div>
                                <div class=""><?php echo form_error('description'); ?></div>

                                <div class="form-group">
                                    <label for="campus"><?php echo $this->lang->line("label_access") ?> :</label>
                                    <?php echo form_dropdown("access", array("private" => "Private", "public" => "Public"),
                                            set_value("access", $form->access), 'class="form-control"'); ?>
                                </div>
                                <div class=""><?php echo form_error('access'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="access-permissions" class="tab-pane fade">
                    <div class="">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="">Manage Access Permissions</h3>
                            </div>
                            <div class="panel-body">

                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <h4>Group Permissions</h4>
                                    <?php
                                    foreach ($group_perms as $key => $value) {
                                        echo form_checkbox("perms[]", $key, (in_array($key, $current_perms)) ? TRUE : FALSE);
                                        echo ucfirst($value) . "</br>";
                                    } ?>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <h4>User Permissions</h4>
                                    <?php
                                    foreach ($user_perms as $key => $value) {
                                        echo form_checkbox("perms[]", $key, (in_array($key, $current_perms)) ? TRUE : FALSE);
                                        echo ucfirst($value) . "</br>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="map-columns" class="tab-pane fade">
                    <div class="">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="">Map columns</h3>
                            </div>
                            <div class="panel-body">

                                <table class="table table-responsive table-bordered table-striped">
                                    <tr>
                                        <th class="text-center">Hide</th>
                                        <th class="text-center">Question/Label</th>
                                        <th class="text-center">Mapping To</th>
                                    </tr>
                                    <?php

                                    foreach ($table_fields as $tf) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . form_checkbox("hide[]", $tf['id'], ($tf['hide'] == 1)) . "</td>";
                                        echo "<td>" . form_hidden("ids[]", $tf['id']) . " " . form_input("label[]", $tf['field_label'], 'class="form-control"') . "</td>";
                                        echo "<td><em>{$tf['col_name']}</em></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">Save changes</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>

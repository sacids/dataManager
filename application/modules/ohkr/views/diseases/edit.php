<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">Edit disease</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/diseases') ?>">Diseases</a></li>
                <li class="active">Edit disease</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-sm-12">
                    <?php echo form_open(uri_string(), 'role="form"'); ?>
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#diseaseInfo" aria-controls="diseaseInfo" role="tab" data-toggle="tab">Disease
                                    Info</a>
                            </li>
                            <li role="presentation">
                                <a href="#alertMsgTab" aria-controls="alertMsgTab" role="tab" data-toggle="tab">Alert
                                    Messages</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active " id="diseaseInfo" style="padding-top: 10px;">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("label_disease_name") ?> <span class="red"> * </span></label>
                                            <input type="text" name="name" placeholder="Enter disease name" class="form-control" value="<?php echo $disease->title; ?>">
                                        </div>
                                        <div class="error" style="color: red"><?php echo form_error('name'); ?></div>

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("label_specie_name") ?> <span class="red"> * </span></label>
                                            <?php
                                            
                                            foreach ($species as $specie) {
                                                $species_options[$specie->id] = $specie->title;
                                            }
                                            echo form_dropdown("specie[]", $species_options, $assigned_species, 'class="form-control chosen-select" data-placeholder="-- Select --" multiple')
                                            ?>
                                        </div>
                                        <div class="error" style="color: red"><?php echo form_error('specie'); ?></div>

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("label_description") ?> :</label>
                                            <textarea class="form-control" name="description" id="description"><?php echo $disease->description; ?></textarea>

                                            <script>
                                                CKEDITOR.replace('description');
                                            </script>
                                        </div>
                                        <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                                    </div>
                                    <!--./col-md-12 -->
                                </div>
                                <!--./row -->
                            </div>
                            <!--./tab-panel -->

                            <div role="tabpanel" class="tab-pane" id="alertMsgTab" style="padding-top: 10px;">

                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo anchor("ohkr/add_new_response_sms/" . $disease->id, '<button type="button" class="btn btn-primary">Add Disease Alert SMS</button>', "class='pull-right' style='margin-bottom:10px;'"); ?>

                                        <table class="table table-responsive table-bordered ">

                                            <tr>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Message</th>
                                                <th class="text-center">Date created</th>
                                                <th class="text-center">status</th>
                                                <th colspan="2" class="text-center">Action</th>
                                            </tr>

                                            <?php foreach ($messages as $msg) { ?>
                                                <tr>
                                                    <td><?php echo $msg->name ?></td>
                                                    <td><?php echo $msg->message ?></td>
                                                    <td><?php echo $msg->date_created ?></td>
                                                    <td><?php echo $msg->status ?></td>
                                                    <td><?php echo anchor("ohkr/edit_response_sms/" . $msg->id, "Edit") ?></td>
                                                    <td><?php echo anchor("ohkr/delete_response_sms/" . $msg->id, "Delete") ?></td>
                                                </tr>
                                            <?php } ?>

                                        </table>
                                    </div>
                                    <!--./col-md-12 -->
                                </div>
                                <!--./row -->
                            </div>
                            <!--./tab-panel -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save
                                </button>
                            </div>
                        </div>
                        <!--./col-md-12 -->
                    </div>
                    <!--./row -->
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $("#addAnotherMessage").on("click", function(e) {
            e.preventDefault();
            var alertMessaagesCount = $("#alertMessages").children().length;

            console.log("Has " + alertMessaagesCount + " childrens");

            if (alertMessaagesCount < 5) {
                $(".sigleAlertMessage:first").clone().appendTo("#alertMessages");
            } else {
                alert("You can not have more than five alert messages");
            }
        });
    });
</script>
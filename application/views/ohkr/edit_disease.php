<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">Edit Disease</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Edit disease</li>
            </ol>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open('ohkr/edit_disease/' . $disease->id, 'role="form"'); ?>

                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#diseaseInfo" aria-controls="diseaseInfo" role="tab" data-toggle="tab">Disease
                                    Info</a></li>
                            <li role="presentation">
                                <a href="#alertMsgTab" aria-controls="alertMsgTab" role="tab" data-toggle="tab">Alert
                                    Messages</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active " id="diseaseInfo" style="padding: 20px;">

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_disease_name") ?> <span>*</span></label>
                                    <input type="text" name="name" placeholder="Enter disease name" class="form-control"
                                           value="<?php echo $disease->d_title; ?>">
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('name'); ?></div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                                    <select name="specie" id="specie" class="form-control">
                                        <option value="<?= $disease->s_id ?>"><?= $disease->s_title ?></option>
                                        <?php foreach ($species as $specie) { ?>
                                            <option value="<?php echo $specie->id; ?>"><?php echo $specie->title; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('specie'); ?></div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_description") ?> :</label>
                                    <textarea class="form-control" name="description"
                                              id="description"><?php echo $disease->description; ?></textarea>
                                    <script>
                                        CKEDITOR.replace('description');
                                    </script>
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="alertMsgTab" style="padding: 20px;">

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
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

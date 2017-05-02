<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">Add disease details</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-12">

                <?php echo form_open('ohkr/add_new_disease', 'class="form-horizontal" role="form"'); ?>
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
                            <h3>Disease Details</h3>

                            <div class="form-group">
                                <label><?php echo $this->lang->line("label_disease_name") ?> <span>*</span></label>
                                <input type="text" name="name" placeholder="Enter disease name" class="form-control"
                                       value="<?php echo set_value('name'); ?>">
                            </div>
                            <div class="error" style="color: red"><?php echo form_error('name'); ?></div>

                            <div class="form-group">
                                <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                                <?php
                                $species_options = array("" => "Choose species");

                                foreach ($species as $specie) {
                                    $species_options[$specie->id] = $specie->title;
                                }
                                echo form_dropdown("specie", $species_options, set_value("specie"), array("id" => "specie", "class" => "form-control"))
                                ?>
                            </div>
                            <div class="error" style="color: red"><?php echo form_error('specie'); ?></div>

                            <div class="form-group">
                                <label><?php echo $this->lang->line("label_description") ?> :</label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>

                                <script>
                                    CKEDITOR.replace('description');
                                </script>
                            </div>
                            <div class="error" style="color: red"><?php echo form_error('description'); ?></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="alertMsgTab" style="padding: 20px;">
                            <div class="form-group">
                                <h3>Alert Messages</h3>
                            </div>

                            <div id="alertMessages">

                                <?php

                                $user_groups = array("" => "Choose Group to alert");
                                foreach ($groups as $group) {
                                    $user_groups[$group->id] = $group->name;
                                }

                                $input = $this->input->post('message');

                                if ($this->form_validation->run() === FALSE && $input) {
                                    foreach ($this->input->post('message') as $index => $item) {
                                        ?>

                                        <div class="sigleAlertMessage">

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("label_recipient_group") ?>
                                                    <span>*:</span></label>
                                                <?php echo form_dropdown("group[]", $user_groups, set_value("group[" . $index . "]"), array("id" => "group", "class" => "form-control")) ?>
                                            </div>

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("label_alert_message") ?> *:</label>
                                            <textarea class="form-control" name="message[]"
                                                      id="message"><?php echo set_value('message[' . $index . ']'); ?></textarea>
                                            </div>
                                            <div class="error"
                                                 style="color: #ff2b0d"><?php echo form_error('message'); ?></div>
                                        </div>

                                    <?php }
                                } else {
                                    ?>

                                    <div class="sigleAlertMessage">

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("label_recipient_group") ?>
                                                <span>*:</span></label>
                                            <select name="group[]" id="group" class="form-control">
                                                <option value="">Choose Group</option>
                                                <?php foreach ($groups as $group) { ?>
                                                    <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("label_alert_message") ?> *:</label>
                                            <textarea class="form-control" name="message[]"
                                                      id="message"><?php echo set_value('message[]'); ?></textarea>
                                        </div>
                                        <div class="error"
                                             style="color: #ff2b0d"><?php echo form_error('message'); ?></div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="addAnotherMessage">Add Another
                                    Message
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        $("#addAnotherMessage").on("click", function (e) {
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
<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 26-Aug-16
 * Time: 16:52
 */
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">Add New Disease Response SMS</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php echo form_open('ohkr/add_new_response_sms/' . $disease_id, 'class="form-horizontal" role="form"'); ?>


                <div class="form-group">
                    <label><?php echo $this->lang->line("label_recipient_group") ?>
                        <span>*:</span></label>
                    <?php

                    $status = array("" => "Choose Group to alert");
                    foreach ($groups as $group) {
                        $status[$group->id] = $group->name;
                    }

                    echo form_dropdown("group", $status, set_value("group"),
                            array("id" => "group", "class" => "form-control"));
                    ?>
                </div>
                <div class="error" style="color: #ff2b0d"><?php echo form_error('group'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_alert_message") ?> *:</label>
                    <textarea class="form-control" name="message" rows="5"
                              id="message"><?php echo set_value('message'); ?>
                    </textarea>
                </div>
                <div class="error" style="color: #ff2b0d"><?php echo form_error('message'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_status") ?><span>*:</span></label>
                    <?php
                    $status = array("" => "Choose Status", "Enabled" => "Enabled", "Disabled" => "Disabled");
                    echo form_dropdown("status", $status, set_value("status"), array("id" => "status", "class" => "form-control"));
                    ?>
                </div>
                <div class="error" style="color: #ff2b0d"><?php echo form_error('status'); ?></div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

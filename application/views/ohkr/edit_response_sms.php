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
                <h3 class="title">Edit Disease Response SMS</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php echo anchor("ohkr/add_new_response_sms/" . $message->disease_id, '<button type="button" class="btn btn-primary">Add Disease Alert SMS</button>', "class='pull-right' style='margin-bottom:10px;'"); ?>


                <?php echo form_open('ohkr/edit_response_sms/' . $message->id, 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_recipient_group") ?>
                        <span>*:</span></label>
                    <?php

                    $user_groups = array("" => "Choose Group to alert");
                    foreach ($groups as $group) {
                        $user_groups[$group->id] = $group->name;
                    }

                    echo form_dropdown("group", $user_groups, set_value("group", $message->group_id),
                            array("id" => "group", "class" => "form-control"));
                    ?>
                </div>
                <div class="error" style="color: #ff2b0d"><?php echo form_error('group'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_alert_message") ?> *:</label>
                    <textarea class="form-control" name="message" rows="10" cols="100"
                              id="message"><?php echo set_value('message', $message->message); ?>
                    </textarea>
                </div>
                <div class="error" style="color: #ff2b0d"><?php echo form_error('message'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
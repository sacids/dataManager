<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/chat.css">
<div class="grid_11" style="padding-top: 20px; text-align: left;">

    <?php echo form_open('feedback/user_feedback', 'class="pure-form pure-form-aligned"'); ?>
    <div class="formCon">
        <div class="formConInner">
            <h3>Feedback</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <fieldset>
                <div class="pure-control-group">
                    <label for="campus">Message :</label>
                        <textarea class="pure-input-1-2" name="message"
                                  id="message"><?php echo set_value('message'); ?></textarea>
                </div>
                <div class="pure-form-message-inline"><?php echo form_error('message'); ?></div>

                <div class="pure-control-group">
                    <label>&nbsp; &nbsp; &nbsp;</label>
                    <button type="submit" name="submit" class="pure-button pure-button-primary">Send</button>
                </div>

            </fieldset>
        </div>
    </div>
    <?php echo form_close(); ?>

    <ol class="chat">
        <?php foreach ($feedback as $values) {
            if ($values->sender == 'user') $class = "other"; else $class = "self"; ?>
            <li class="<?php echo $class; ?>">
                <div class="avatar"><img src="<?php echo base_url(); ?>assets/public/images/profile.png"
                                         draggable="false"/></div>
                <div class="msg">
                    <p><?php echo $values->message; ?></p>
                    <time><?php echo $values->date_created; ?></time>
                </div>
            </li>
        <?php } ?>
    </ol>

</div>

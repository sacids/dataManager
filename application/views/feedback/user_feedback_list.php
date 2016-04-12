<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/chat.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php echo form_open(uri_string(), 'class="form-horizontal" role="form"'); ?>
            <h3>Feedback</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <fieldset>
                <div class="form-group">
                    <label for="campus">Message :</label>
                        <textarea class="form-control" name="message"
                                  id="message"><?php echo set_value('message'); ?></textarea>
                </div>
                <?php echo form_error('message'); ?>

                <div class="form-group">
                    <label>&nbsp; &nbsp; &nbsp;</label>
                    <button type="submit" name="submit" class="btn btn-primary">Send</button>
                </div>

            </fieldset>
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
    </div>
</div>

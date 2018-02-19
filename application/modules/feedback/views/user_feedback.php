<link rel="stylesheet" type="text/css" href="<?= base_url('assets/public/css/chat.css'); ?>">
<script src="<?= base_url('assets/public/js/chat.js '); ?>"></script>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Feedback conversation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('feedback/lists') ?>">Feedback Messages</a></li>
                <li class="active">Conversation</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <ol class="chat">
                        <?php foreach ($feedback as $values) {
                            if ($values->sender == "user") $class = "self"; else $class = "other"; ?>
                            <li class="<?php echo $class; ?>">
                                <div class="msg">
                                    <p><?= $values->message ?></p>
                                    <span><?php echo $values->sender_name; ?></span>
                                    <time><?= date('H:i:s', strtotime($values->date_created)) ?></time>
                                </div>
                            </li>
                        <?php } ?>
                    </ol>
                </div><!-- ./col-sm-12 -->

                <?= form_open('', 'class="feedback_form" id="form"') ?>
                <input class="textarea" type="text" name="message" id="message" placeholder="Type feedback here!"
                       required/>
                <button type="submit" name="submit" class="submit btn btn-primary">Send
                </button>
                <?= form_close() ?>

            </div><!--./row -->
        </div><!--./col-sm-12 -->
    </div><!--./row -->
</div><!--./container -->

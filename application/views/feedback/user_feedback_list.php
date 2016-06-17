<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/public/css/chat.css">
<script src="<?php echo site_url(); ?>assets/public/js/chat.js"></script>


<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Feedback</h3>
            <div class="col-sm-12">
                <ol class="chat">
                    <?php foreach ($feedback as $values) {
                        if ($values->sender == "user") $class = "self"; else $class = "other"; ?>
                        <li class="<?php echo $class; ?>">
                            <div class="msg">
                                <p><?= $values->message ?></p>
                                <span><?= $values->fname . ' ' . $values->lname; ?></span>
                                <time><?= date('H:i:s', strtotime($values->date_created)) ?></time>
                            </div>
                        </li>
                    <?php } ?>
                </ol>
            </div>

            <form method="post" id="form" class="feedback_form">
                <input class="textarea" type="text" name="message" id="message" placeholder="Type feedback here!"/>
                <input type="hidden" name="instance_id" id="instance_id" value=""/>
                <button type="submit" name="submit" class="submit btn btn-primary" onClick="submitdata();">Send</button>
            </form>

        </div>
    </div>
</div>

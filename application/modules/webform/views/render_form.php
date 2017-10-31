<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 09/10/2017
 * Time: 09:57
 */ ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $form_title; ?> Form</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-12">
                <?= $web_form ?>
            </div>
        </div>
    </div>
</div>
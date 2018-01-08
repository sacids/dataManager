<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 12:14
 */
?>
<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add new post</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('blog/post/lists') ?>">Newsletter Post</a></li>
                <li class="active">Add new post</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open_multipart('blog/post/add_new', 'class="form-horizontal" role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?= $this->lang->line("label_post_title") ?> <span
                                        style="color: red;">*</span></label>
                            <?= form_input($name) ?>
                        </div>

                        <div class="form-group">
                            <label>Media <span style="color: red;">*</span></label>
                            <?= form_upload($attachment) ?>
                        </div>

                        <div class="form-group">
                            <label><?= $this->lang->line("label_content") ?> <span style="color: red;">*</span></label>
                            <?= form_textarea($content); ?>
                            <script>
                                CKEDITOR.replace('content');
                            </script>
                        </div>

                        <div class="form-group">
                            <label><?= $this->lang->line("label_status") ?></label>
                            <?= form_dropdown("status", array("draft" => "Draft", "published" => "Published"), set_value("access", ""), 'class="form-control"'); ?>
                        </div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Save', 'class="btn btn-primary"') ?>
                        </div>
                    </div><!--./col-sm-8 -->
                    <?php echo form_close(); ?>


                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>


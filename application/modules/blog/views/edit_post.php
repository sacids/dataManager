<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 16:01
 */
?>
<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <?php echo form_open_multipart('blog/post/edit_post/'.$post->id, 'class="form-horizontal" role="form"'); ?>
        <div class="col-sm-12 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1">

            <h3>New post</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <div class="form-group">
                    <label><?php echo $this->lang->line("label_post_title") ?> <span>*</span></label>
                    <input type="text" name="title" placeholder="Post title" class="form-control"
                           value="<?php echo set_value('title', $post->title); ?>">
                </div>
                <?php echo form_error('title'); ?>

                <!--<div class="form-group">
                    <label for=""><?php /*echo $this->lang->line("label_form_xml_file") */ ?><span>*</span></label>
                    <? /*= form_upload("userfile") */ ?>
                </div>-->

                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_content") ?> :</label>
                        <textarea class="form-control" name="content" placeholder="Enter post here"
                                  id="description"><?php echo set_value('content', $post->content); ?></textarea>
                    <script>
                        CKEDITOR.replace('content');
                    </script>
                </div>
                <?php echo form_error('description'); ?>

                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_status") ?> :</label>
                    <?php echo form_dropdown("status", array("draft" => "Draft", "published" => "Published"), set_value("access", $post->status ), 'class="form-control"'); ?>
                </div>
                <?php echo form_error('access'); ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

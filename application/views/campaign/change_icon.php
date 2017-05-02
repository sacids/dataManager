<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Change campaign icon</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <img src="<?= base_url() ?>assets/forms/data/images/<?= $campaign->icon ?>" width="400" height="300"/>
                <br>
                <br>

                <?php echo form_open_multipart('campaign/change_icon/' . $campaign->id, 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_campaign_icon"); ?> <span>*</span></label>
                    <input type="file" name="icon">
                </div>
                <div class="error" style="color: red"><?php echo form_error('icon'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>


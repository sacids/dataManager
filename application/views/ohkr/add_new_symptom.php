<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add Clinical manifestation Details</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">

                <?php echo form_open('ohkr/add_new_symptom', 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_symptom_name") ?> <span>*</span></label>
                    <input type="text" name="name" placeholder="Enter title" class="form-control"
                           value="<?php echo set_value('name'); ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('name'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_symptom_code") ?> <span>*</span></label>
                    <input type="text" name="code" placeholder="Enter code" class="form-control"
                           value="<?php echo set_value('code'); ?>">
                </div>
                <div class="error" style="color: red"><?php echo form_error('code'); ?></div>

                <div class="form-group">
                    <label> <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label> </label>
                    <textarea class="form-control" name="description"
                              id="description"><?php echo set_value('description'); ?></textarea>
                    <script>
                        CKEDITOR.replace('description');
                    </script>
                </div>
                <?php echo form_error('description'); ?>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

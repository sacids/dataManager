<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <h3>Edit Campaign Details</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>


            <div class="col-sm-8">
                <?php echo form_open('campaign/edit/' . $campaign->id, 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_campaign_title"); ?> <span>*</span></label>
                    <input type="text" name="title" placeholder="Enter Campaign Title" class="form-control"
                           value="<?php echo $campaign->c_title; ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('title'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_campaign_type"); ?> <span>*</span></label>
                    <select name="type" id="type" class="form-control">
                        <option
                            value="<?php echo $campaign->type; ?>"><?php echo ($campaign->type == "general") ? "General Campaign" : "Form Campaign"; ?></option>
                        <option value="general">General Campaign</option>
                        <option value="form">Form Campaign</option>
                    </select>
                </div>
                <div class="error" style="color: red"><?php echo form_error('type'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_form_name"); ?> </label>
                    <select name="form_id" id="form_id" class="form-control">
                        <option value="<?php echo $campaign->form_id;?>"><?php echo $campaign->x_title;?></option>
                        <?php foreach ($forms as $form) { ?>
                            <option value="<?php echo $form->jr_form_id ?>"><?php echo $form->title; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="error" style="color: red"><?php echo form_error('form_id'); ?></div>


                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo $campaign->description; ?></textarea>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace('description');
                    </script>
                </div>
                <div class="error" style="color: red"><?php echo form_error('description'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>


                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>


<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Edit Symptom Details</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <?php echo form_open('ohkr/edit_symptom/' . $symptom->id, 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_symptom_name") ?> <span>*</span></label>
                    <input type="text" name="name" placeholder="Enter symptom name" class="form-control"
                           value="<?php echo $symptom->title; ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('name'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_symptom_code") ?> <span>*</span></label>
                    <input type="text" name="code" placeholder="Enter symptom code" class="form-control"
                           value="<?php echo $symptom->code; ?>">
                </div>
                <div class="error" style="color: red"><?php echo form_error('code'); ?></div>

                <div class="form-group">
                    <label> <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label> </label>
                    <textarea class="form-control" name="description"
                              id="description"><?php echo $symptom->description; ?></textarea>
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

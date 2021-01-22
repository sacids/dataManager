<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Add Specie Details</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-6">

                <?php echo form_open_multipart('ohkr/add_new_specie', 'class="form-horizontal" role="form"'); ?>


                <div class="form-group">
                    <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                    <input type="text" name="specie" placeholder="Enter specie title" class="form-control"
                           value="<?php echo set_value('specie'); ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('specie'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>


                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

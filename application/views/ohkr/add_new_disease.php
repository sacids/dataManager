<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php echo form_open_multipart('ohkr/add_new_disease', 'class="form-horizontal" role="form"'); ?>

            <h3>Add Disease Details</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>


                <div class="form-group">
                    <label><?php echo $this->lang->line("label_disease_name") ?> <span>*</span></label>
                    <input type="text" name="name" placeholder="Enter disease name" class="form-control"
                           value="<?php echo set_value('name'); ?>">
                </div>
                <?php echo form_error('name'); ?>

                <div class="form-group">
                    <label> <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label> </label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>
                </div>
                <?php echo form_error('description'); ?>

                <div class="form-group">
                    <label>&nbsp; &nbsp; &nbsp;</label>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>



            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php echo form_open_multipart('xform/add_new', 'class="form-horizontal" role="form"'); ?>
        <div class="col-sm-12 col-md-6 col-lg-6">

            <h3>Form Details</h3>


            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <div class="form-group">
                    <label><?php echo $this->lang->line("label_form_title") ?> <span>*</span></label>
                    <input type="text" name="title" placeholder="Enter form title" class="form-control"
                           value="<?php echo set_value('title'); ?>">
                </div>
                <?php echo form_error('title'); ?>


                <div class="form-group">
                    <label for=""><?php echo $this->lang->line("label_form_xml_file") ?><span>*</span></label>
                    <?= form_upload("userfile") ?>
                </div>

                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>
                </div>
                <?php echo form_error('description'); ?>

                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_access") ?> :</label>
                    <?php echo form_dropdown("access", array("private" => "Private", "public" => "Public"), set_value("access", ""), 'class="form-control"'); ?>
                </div>
                <?php echo form_error('access'); ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6">
            <h3>Permissions</h3>
            <p class="alert alert-info"> Select who can access the forms </p>
            <div>
                <?php
                foreach ($perms as $key => $value) {

                    echo form_checkbox("perms[]", $key, FALSE);
                    echo $value . "</br>";
                } ?>
            </div>

        </div>
        <?php echo form_close(); ?>
    </div>
</div>

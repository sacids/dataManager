<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

    <?php echo form_open_multipart('campaign/add_new', 'class="form-horizontal" role="form"'); ?>

            <h3>Campaign Details</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <fieldset>
                <div class="form-group">
                    <label>Campaign Title <span>*</span></label>
                    <input type="text" name="title" placeholder="Enter Campaign Title" class="form-control"
                           value="<?php echo set_value('title'); ?>">
                </div>
                <?php echo form_error('title'); ?>

                <div class="form-group">
                    <label>Campaign Icon <span>*</span></label>
                    <input type="text" name="icon" placeholder="Enter campaign icon" class="form-control"
                           value="<?php echo set_value('icon'); ?>">
                </div>
                <?php echo form_error('icon'); ?>


                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo set_value('description'); ?></textarea>
                </div>
                <?php echo form_error('description'); ?>

                <div class="form-group">
                    <label for="campus">Form Id :</label>
                    <select name="form_id" id="form_id" class="form-control">
                        <option value="">Choose form</option>
                        <?php foreach($forms as $form){?>
                        <option value="<?php echo $form->form_id?>"><?php echo $form->form_id?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php echo form_error('form_id'); ?>

                <div class="form-group">
                    <label>&nbsp; &nbsp; &nbsp;</label>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </fieldset>

    <?php echo form_close(); ?>
        </div>
    </div>
</div>


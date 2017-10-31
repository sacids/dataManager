<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Add Module</h3>


            <div class="col-sm-6">

                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                } ?>

                <?php echo form_open('auth/add_module', 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label>Module <span>*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter module" class="form-control"
                           value="<?php echo set_value('name'); ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('name'); ?></div>

                <div class="form-group">
                    <label>Controller <span>*</span></label>
                    <input type="text" id="name" name="controller" placeholder="Enter controller" class="form-control"
                           value="<?php echo set_value('controller'); ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('controller'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

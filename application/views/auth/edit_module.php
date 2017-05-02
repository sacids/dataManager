<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit module</h3>
            </div>

            <div class="col-sm-6">
                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                } ?>

                <?php echo form_open('auth/edit_module/' . $module->id, 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label>Module <span>*</span></label>
                    <input type="text" name="name" placeholder="Enter module" class="form-control"
                           value="<?php echo $module->name; ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('module'); ?></div>

                <div class="form-group">
                    <label>Controller <span>*</span></label>
                    <input type="text" name="controller" placeholder="Enter controller" class="form-control"
                           value="<?php echo $module->controller; ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('controller'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

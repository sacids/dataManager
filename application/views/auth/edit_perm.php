<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Edit Perm</h3>


            <div class="col-sm-6">

                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                } ?>

                <?php echo form_open('auth/edit_perm/' . $perm->id, 'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label>Perm name <span>*</span></label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="<?php echo $perm->name; ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('name'); ?></div>

                <div class="form-group">
                    <label>Perm Slug <span>*</span></label>
                    <input type="text" id="perm_slug" name="perm_slug"
                           class="form-control"
                           value="<?php echo $perm->perm_slug; ?>">
                </div>
                <div class="error" style="color: red"> <?php echo form_error('perm_slug'); ?></div>

                <div class="form-group">
                    <label>Module <span>*</span></label>
                    <select name="module" id="module" class="form-control">
                        <option value="<?= $perm->module_id ?>"><?= $module_name ?></option>
                        <?php foreach ($module as $value) { ?>
                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="error" style="color: red"> <?php echo form_error('module'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

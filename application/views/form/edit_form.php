<div class="container">
    <div class="row">
        <?php echo form_open_multipart('xform/edit_form/' . $form->id, 'class="form-horizontal" role="form"'); ?>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <!-- Trigger the modal with a button -->
            <div id="header-title">
                <h3 class="title">Edit form details<span class="pull-right">
                    <?php echo anchor("xform/map_fields/" . $form->form_id, "Map columns") ?></h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            }
            ?>
            <div class="col-sm-8">
                <div class="form-group">
                    <?php echo form_label($this->lang->line("label_form_title"), " <span>*</span>"); ?>
                    <input type="text" name="title" placeholder="Enter form title" class="form-control"
                           value="<?php echo set_value('title', $form->title); ?>">
                </div>
                <div class=""><?php echo form_error('title'); ?></div>

                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_description") ?>:</label>
                        <textarea class="form-control" name="description"
                                  id="description"><?php echo set_value('description', $form->description); ?></textarea>
                </div>
                <div class=""><?php echo form_error('description'); ?></div>

                <div class="form-group">
                    <label for="campus"><?php echo $this->lang->line("label_access") ?> :</label>
                    <?php echo form_dropdown("access", array("private" => "Private", "public" => "Public"), set_value("access", $form->access), 'class="form-control"'); ?>
                </div>
                <div class=""><?php echo form_error('access'); ?></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <h3>Permissions</h3>
            <p class="alert alert-info">Modify form access permissions</p>
            <div>
                <?php
                foreach ($perms as $key => $value) {
                    echo form_checkbox("perms[]", $key, (in_array($key, $current_perms)) ? TRUE : FALSE);
                    echo $value . "</br>";
                } ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

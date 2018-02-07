<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 25/10/2017
 * Time: 15:22
 */

?>

<?php
/**
 * Created by PhpStorm.
 * User: Godlcuk Akyoo
 * Date: 25/10/2017
 * Time: 12:08
 */ ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h3><i class="fa fa-key"></i> New Permission</h3>
            <hr/>
            <?= get_flashdata() ?>

            <?= form_open("auth/accesscontrol/new_permission", 'class="form-horizontal" role="form"') ?>
            <div class="form-group">
                <label>Permission name <span>*</span></label>
                <input type="text" id="permissionName" name="permission" placeholder="Enter permission name"
                       class="form-control"
                       value="<?php echo set_value('permission'); ?>">
                <div class="error" style="color: red"> <?php echo form_error('permission'); ?></div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <?= form_textarea(["id" => "permissionDescription", "name" => "description", "placeholder" => "Enter permission short description here", "class" => "form-control"], set_value('description')) ?>
                <div class="error" style="color: red"> <?php echo form_error('description'); ?></div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

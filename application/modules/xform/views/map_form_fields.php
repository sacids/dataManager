<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 14-Jul-16
 * Time: 16:26
 */

?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div>
                <div class="page-header">
                    <h3>Field mappings</h3>
                </div>
                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                }
                ?>

                <?php echo form_open("xform/map_fields/" . $form_id); ?>
                <table class='table table-responsive table-bordered table-striped'>

                    <?php foreach ($field_maps as $field): ?>
                        <tr>
                            <td><label class="col-lg-4 control-label"><?php echo $field['field_name'] ?></label></td>
                            <td><input type="text" name="<?php echo $field['col_name']; ?>"
                                       value="<?php echo $field['field_label']; ?>" class="form-control"/>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    <tr>
                        <td colspan='2' style='text-align: right;'>
                            <input type="submit" name="save" value="Save Changes" class="btn btn-primary btn-lg"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>



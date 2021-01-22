<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <h3>Assign Permission to <?php echo strtoupper($group_name); ?> group</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <?php echo form_open('auth/perms_group/' . $group_id) ?>

            <?php
            foreach ($perm_list[0] as $key => $value) { ?>
                <legend
                    style="font-weight: normal; text-transform: uppercase;"><?php echo 'Module : ' . $key; ?></legend>
                <?php
                foreach ($value as $k => $v):
                    $module_id = $perm_list[1][$key][$k]; ?>

                    <div class="form-group" style="border-bottom: 1px dotted black;">
                        <label><?php echo $module_id[2]; ?></label>
                        <input type="checkbox"
                               name="module_<?php echo $module_id[0] . '_' . $module_id[1] ?>" <?php echo($v == 1 ? 'checked="checked"' : ''); ?>
                               value="1">

                    </div>
                <?php endforeach; ?>
            <?php } ?>

            <input type="submit" value="Save" name="save" class="btn btn-primary"/>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
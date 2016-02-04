<div class="grid_11" style="padding-top: 20px; text-align: left;">

    <?php echo form_open('auth/assign_privilege/'.$group_id, 'class="pure-form pure-form-aligned"') ?>
    <div class="formCon">
        <div class="formConInner">
            <h3>Assign Privilege to group <?php echo strtoupper($group_name); ?></h3>

            <?php
            if(isset($message)):
                echo '<div class="success_message">' . $message . '</div>';
            elseif($this->session->flashdata('message') != ''):
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            endif;

            foreach ($privilege_list[0] as $key => $value) { ?>
                <fieldset style="width: 100%; padding-bottom: 20px;">
                    <legend style="font-weight: bold; text-transform: uppercase;"><?php echo 'Module : '.$key;?></legend>
                    <?php
                    foreach ($value as $k => $v):
                        $module_id = $privilege_list[1][$key][$k]; ?>

                        <div class="pure-control-group" style="border-bottom: 1px dotted black;">
                            <label style="text-align: left;" ><?php echo $k ?></label>
                            <input  type="checkbox" name="module_<?php echo $module_id[0].'_'.$module_id[1] ?>" <?php echo ($v==1 ? 'checked="checked"':''); ?> class="pure-input-1-2" value="1" placeholder="Group name">

                        </div>
                    <?php endforeach; ?>
                </fieldset>
            <?php } ?>


            <div class="pure-control-group">
                <label>&nbsp; &nbsp; &nbsp; <input name="save" value="1" type="hidden"/>  </label>
                <button type="save"  class="pure-button pure-button-primary">Save</button>
            </div>
        </div>
    </div>

    <?php echo form_close(); ?>

</div>

</div>  </div> </div>

<div class="grid_11" id="grid_padding">

<?php echo form_open('auth/change_password', 'class="pure-form pure-form-aligned"') ?>
<div class="formCon">
    <div class="formConInner">
        <h3>Fill information to change password</h3>
 
        <fieldset > 
    <div class="pure-control-group">
          <label>  <?php echo lang('change_password_old_password_label', 'old_password');?></label>
            <?php echo form_input($old_password);?>
      </div>
<div class="pure-form-message-inline"><?php echo form_error('old'); ?></div>

        <div class="pure-control-group">
          <label> <?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> 
            <?php echo form_input($new_password);?>
        </div>
<div class="pure-form-message-inline"><?php echo form_error('new'); ?></div>

         <div class="pure-control-group">
             <label> <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> </label>
            <?php echo form_input($new_password_confirm);?>
         </div>
<div class="pure-form-message-inline"><?php echo form_error('new_confirm'); ?></div>

      <?php echo form_input($user_id);?>
               <div class="pure-control-group">
                   <label> &nbsp;</label>
      <input type="submit" value="Change Password"  class="pure-button pure-button-primary"/>


        </fieldset>
    </div>
</div>
<?php echo form_close();?>  

</div>
    <div style="clear: both;"></div>
    </div>            </div>
        </div>

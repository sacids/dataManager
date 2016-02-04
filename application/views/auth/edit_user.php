  <div class="grid_11" id="grid_padding">
       
<?php echo form_open(uri_string(), 'class="pure-form pure-form-aligned"') ?>
<div class="formCon">
    <div class="formConInner">
        <h3>Edit User Account</h3>
        <?php
        if($this->session->flashdata('message') != ''):
            echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
        elseif(isset($error_in)):
            echo '<div class="fail_message">' . $error_in . '</div>';
        endif;?>

                <fieldset style="width: 90%;">
            <legend>Basic User Information</legend>
            <div class="pure-control-group">
                <label> <label for="first_name">First Name:<span>*</span></label> </label>  
                <?php echo form_input($first_name); ?>                
     </div>
    <div class="pure-form-message-inline"><?php echo form_error('first_name'); ?></div>
            
            <div class="pure-control-group">
                <label>  <label for="last_name">Last Name:<span>*</span></label> </label>
    <?php echo form_input($last_name); ?>
        </div>
            <div class="pure-form-message-inline"><?php echo form_error('last_name'); ?></div>

            <div class="pure-control-group">
                <label>  <label for="email">Email:</label> </label>
                <?php echo form_input($email); ?></div>
            <div class="pure-form-message-inline"><?php echo form_error('email'); ?></div>

            <div class="pure-control-group">
                <label>  <label for="phone">Phone:<span>*</span></label> </label>
                <?php echo form_input($phone); ?></div>
            <div class="pure-form-message-inline"><?php echo form_error('phone'); ?></div>
                    </fieldset>

        <fieldset style="width: 90%;">
            <legend>Account User</legend>

      <div class="pure-control-group">
                <label>  <label for="group">Group:<span>*</span></label> </label>
    <?php foreach ($groups as $group):?>
  <?php
    $gID=$group['id'];
    $checked = null;
    $item = null;
    foreach($currentGroups as $grp) {
      if ($gID == $grp->id) {
        $checked= ' checked="checked"';
      break;
      }
    }
  ?>
  <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?> >
  <?php echo $group['name'];?>
  <?php endforeach?>
   
            </div>
<div class="pure-form-message-inline"><?php echo form_error('group'); ?></div>
            
            <div class="pure-control-group">
                <label>  <label for="password">Password:<br/><small>(if changing password)</small></label> </label>
 <?php echo form_input($password); ?></div>
<div class="pure-form-message-inline"><?php echo form_error('password'); ?></div>

            <div class="pure-control-group">
                <label>  <label for="password_confirm">Confirm Password:<br/><small>(if changing password)</small></label> </label>
                  <?php echo form_input($password_confirm); ?></div>

 <?php  echo form_hidden('id', $user->id); ?>
            <?php echo form_hidden($csrf); ?>

                        
              <div class="pure-control-group">
                <label>&nbsp; &nbsp; &nbsp;</label>
                <button type="submit" class="pure-button pure-button-primary">Edit User</button>
            </div>
        </fieldset>

        
    </div>
</div>
</form>    </div>
    <div style="clear: both;"></div>
    </div>            </div>
        </div>
<?php //$this->output->enable_profiler(TRUE); ?>

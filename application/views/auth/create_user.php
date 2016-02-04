  <div class="grid_11" id="grid_padding">

<form action="<?php echo site_url('auth/create_user');?>" class="pure-form pure-form-aligned" method="post" accept-charset="utf-8"><div class="formCon">
    <div class="formConInner">
        <h3>Create User Account</h3>

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
                <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" class="pure-input-1-2" id="first_name"  /> </div>
    <div class="pure-form-message-inline"><?php echo form_error('first_name'); ?></div>
            
            <div class="pure-control-group">
                <label>  <label for="last_name">Last Name:<span>*</span></label> </label>
                <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" id="last_name" class="pure-input-1-2"  /></div>
            <div class="pure-form-message-inline"><?php echo form_error('last_name'); ?></div>

            <div class="pure-control-group">
                <label>  <label for="email">Email:</label> </label>
                <input type="text" name="email" value="<?php echo set_value('email'); ?>" class="pure-input-1-2" id="email"  /></div>
            <div class="pure-form-message-inline"><?php echo form_error('email'); ?></div>

            <div class="pure-control-group">
                <label>  <label for="phone">Phone:<span>*</span></label> </label>
                <input type="text" name="phone" value="<?php echo set_value('phone'); ?>" class="pure-input-1-2" id="phone"  /></div>
                <div class="pure-form-message-inline"><?php echo form_error('phone'); ?></div>
                    </fieldset>

        <fieldset style="width: 90%;">
            <legend>Account User</legend>            
             <div class="pure-control-group">
                <label>  <label for="group">Group:<span>*</span></label> </label>
                <select name="group" id="group" class = "pure-input-1-2">
                <option value="">Choose Group</option>
            <?php 
            $groups=$this->db->order_by('name','asc')->get('groups')->result();
            foreach($groups as $values): ?>
            <option value="<?php echo $values->id;?>"><?php echo $values->name;?></option>
            <?php endforeach; ?>
            </select>
            </div>
            <div class="pure-form-message-inline"><?php echo form_error('group'); ?></div>
            
            <div class="pure-control-group">
                <label>  <label for="password">Password:<span>*</span></label> </label>
                <input type="password" name="password" value="<?php echo set_value('password'); ?>" class="pure-input-1-2" id="password"  /></div>
                <div class="pure-form-message-inline"><?php echo form_error('password'); ?></div>

            <div class="pure-control-group">
                <label>  <label for="password_confirm">Confirm Password:<span>*</span></label> </label>
                <input type="password" name="password_confirm" value="<?php echo set_value('password_confirm'); ?>" id="password_confirm" class="pure-input-1-2"  /></div>
                        
              <div class="pure-control-group">
                <label>&nbsp; &nbsp; &nbsp;</label>
                <button type="submit" class="pure-button pure-button-primary">Create User</button>
            </div>
        </fieldset>

        
    </div>
</div>
</form>    </div>
    <div style="clear: both;"></div>
    </div>            </div>
        </div>


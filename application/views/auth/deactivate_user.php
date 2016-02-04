<div class="grid_11" id="grid_padding">


<?php echo form_open("auth/deactivate/".$user->id,'class="pure-form pure-form-aligned"');?>
<div class="formCon">
    <div class="formConInner">
        <fieldset>
    <h1><?php echo lang('deactivate_heading');?></h1>
<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
        
            
  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p>
  <button type="submit" class="pure-button pure-button-primary"><?php echo lang('deactivate_submit_btn') ?></button>
  
        </fieldset>
    </div>
</div>
<?php echo form_close();?>    

   </div>
    <div style="clear: both;"></div>
    </div>            </div>
        </div>

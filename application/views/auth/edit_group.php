<div class="grid_11" id="grid_padding">

      <form action=""
            class="pure-form pure-form-aligned" method="post" accept-charset="utf-8">
            <div class="formCon">
                  <div class="formConInner">
                        <h3>Edit Group</h3>

                        <?php
                        if($this->session->flashdata('message') != ''):
                              echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                        endif;?>

                        <fieldset style="width: 90%;">

                              <legend>Group Information</legend>
                              <div class="pure-control-group">
                                    <label> <label for="group_name">Group Name:<span>*</span></label> </label>
                                    <input type="text" name="group_name" value="<?php echo $group->name; ?>" class="pure-input-1-2" id="group_name"  /> </div>
                              <div class="pure-form-message-inline"><?php echo form_error('group_name'); ?></div>

                              <div class="pure-control-group">
                                    <label>  <label for="description">Description:</label> </label>
                                    <textarea name="description" id="description"  class="pure-input-1-2" ><?php echo $group->description; ?></textarea>

                                    <div class="pure-control-group">
                                          <label>&nbsp; &nbsp; &nbsp;</label>
                                          <button type="submit" class="pure-button pure-button-primary">Edit</button>
                                    </div>

                        </fieldset>


                  </div>
            </div>
      </form>
</div>

</div> </div> </div>


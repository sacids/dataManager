<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <h3><?php echo $this->lang->line("create_user_heading") ?> </h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo display_message($this->session->flashdata('message'));
            } else if (isset($error_in)) {
                echo display_message($error_in, "danger");
            } ?>

            <div class="col-sm-8">
                <form action="<?php echo site_url('auth/create_user'); ?>" class="form-horizontal" role="form"
                      method="post"
                      accept-charset="utf-8">

                    <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line("create_user_fname_label") ?>
                            <span>*</span></label>
                        <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"
                               class="form-control" id="first_name"/>
                    </div>
                    <?php echo form_error('first_name'); ?>

                    <div class="form-group">
                        <label for="last_name"><?php echo $this->lang->line("create_user_lname_label") ?>
                            <span>*</span></label>
                        <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"
                               id="last_name" class="form-control"/></div>
                    <?php echo form_error('last_name'); ?>

                    <div class="form-group">
                        <label for="identity"><?php echo $this->lang->line("create_user_identity_label") ?>
                            <span>*</span></label>
                        <input type="text" name="identity" value="<?php echo set_value('identity'); ?>"
                               id="identity" placeholder="07XXXXXXXX" class="form-control"/></div>
                    <?php echo form_error('identity'); ?>

                    <div class="form-group">
                        <label for="email"><?php echo $this->lang->line("create_user_email_label"); ?>
                            <span>*</span></label>
                        <input type="text" name="email" value="<?php echo set_value('email'); ?>"
                               class="form-control" id="email"/>
                    </div>
                    <?php echo form_error('email'); ?>

                    <div class="form-group">
                        <label
                            for="Country code"><?php echo $this->lang->line("create_user_country_code_label") ?>
                            <span>*</span></label>
                        <?php echo form_dropdown("country_code", array("254" => "254", "255" => "255", "256" => "256"), set_value("country_code", "255"), "class='form-control'"); ?>
                    </div>
                    <?php echo form_error('country_code'); ?>

                    <div class="form-group">
                        <label for="phone"><?php echo $this->lang->line("create_user_phone_label") ?>
                            <span>*</span></label>
                        <input type="text" name="phone" value="<?php echo set_value('phone'); ?>"
                               class="form-control" id="phone" placeholder=""/>
                    </div>
                    <?php echo form_error('phone'); ?>

                    <div class="form-group">
                        <label for="group">Group: <span>*</span></label>
                        <select name="group" id="group" class="form-control">
                            <option value="">Choose Group</option>
                            <?php
                            $groups = $this->db->order_by('name', 'asc')->get('groups')->result();
                            foreach ($groups as $values): ?>
                                <option value="<?php echo $values->id; ?>"><?php echo $values->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php echo form_error('group'); ?>

                    <div class="form-group">
                        <label for="password"><?php echo $this->lang->line("create_user_password_label") ?>
                            <span>*</span></label>
                        <input type="password" name="password" value="<?php echo set_value('password'); ?>"
                               class="form-control" id="password"/></div>
                    <?php echo form_error('password'); ?>

                    <div class="form-group">
                        <label
                            for="password_confirm"><?php echo $this->lang->line("create_user_password_confirm_label") ?>
                            <span>*</span></label>
                        <input type="password" name="password_confirm"
                               value="<?php echo set_value('password_confirm'); ?>" id="password_confirm"
                               class="form-control"/>
                    </div>
                    <div class="form-group">
                        <button type="submit"
                                class="btn btn-primary"><?php echo $this->lang->line("create_user_heading") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
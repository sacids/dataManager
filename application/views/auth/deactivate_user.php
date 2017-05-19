<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $this->lang->line("deactivate_heading") ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('auth/users_list') ?>">Manage users</a></li>
                <li class="active">Deactivate user</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo display_message($this->session->flashdata('message'));
            } ?>

            <div class="col-sm-8">
                <?php echo form_open("auth/deactivate/" . $user->id, 'class="pure-form pure-form-aligned"'); ?>
                <p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></p>

                <div class="form-group">

                    <?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
                    <input type="radio" name="confirm" value="yes" checked="checked"/><br/>
                    <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
                    <input type="radio" name="confirm" value="no"/>

                </div>

                <?php echo form_hidden($csrf); ?>
                <?php echo form_hidden(array('id' => $user->id)); ?>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
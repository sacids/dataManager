<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $this->lang->line("deactivate_heading") ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('auth/users_list') ?>">Users</a></li>
                <li class="active">Deactivate User</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo display_message($this->session->flashdata('message'));
                    } ?>

                    <?= form_open("auth/deactivate/" . $user->id, 'class="pure-form pure-form-aligned"'); ?>
                    <p><?= sprintf(lang('deactivate_subheading'), $user->username); ?></p>

                    <div class="form-group">
                        <?= lang('deactivate_confirm_y_label', 'confirm'); ?>
                        <input type="radio" name="confirm" value="yes" checked="checked"/><br/>
                        <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
                        <input type="radio" name="confirm" value="no"/>
                    </div>

                    <?= form_hidden($csrf); ?>
                    <?= form_hidden(array('id' => $user->id)); ?>


                    <div class="form-group">
                        <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                        <?= anchor('auth/users_list', 'Cancel', 'class="btn btn-warning"') ?>
                    </div> <!-- /form-group -->
                    <?= form_close(); ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div><!-- ./col-sm-12 -->
    </div><!--./row -->
</div><!--./row -->
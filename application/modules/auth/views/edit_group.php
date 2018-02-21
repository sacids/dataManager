<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit Group</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/group_list') ?>">Groups</a></li>
                <li class="active">Edit group</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">

                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open(uri_string(), 'role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo lang('create_group_name_label', 'group_name'); ?> <span
                                        style="color: red;">*</span></label>
                            <?= form_input($group_name); ?>
                        </div>

                        <div class="form-group">
                            <label><?= lang('create_group_desc_label', 'description'); ?></label>
                            <?= form_textarea($description); ?>
                        </div>

                        <div class="form-group">
                            <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                            <?= anchor('auth/group_list', 'Cancel', 'class="btn btn-warning"') ?>
                        </div> <!-- /form-group -->
                    </div><!--./col-sm-6 -->
                    <?= form_close(); ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div><!--./col-sm-12 -->
    </div><!--./row -->
</div><!--./container -->



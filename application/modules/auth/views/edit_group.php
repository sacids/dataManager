<div class="container" id="content-middle">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit group</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Edit group</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open(uri_string(), 'role="form"'); ?>
                    <div class="form-group">
                        <label><?php echo lang('create_group_name_label', 'group_name'); ?> <span
                                    style="color: red;">*</span></label>
                        <?php echo form_input($group_name); ?>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('create_group_desc_label', 'description'); ?></label>
                        <?php echo form_textarea($description); ?>
                    </div>

                    <div class="form-group">
                        <?php echo form_submit('submit', 'Change', array('class' => "btn btn-primary")); ?>
                    </div>

                    <?php echo form_close(); ?>


                </div>
            </div>

        </div>
    </div>
</div>



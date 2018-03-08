<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $this->lang->line("title_edit_project") ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projects</a></li>
                <li class="active"><?= $this->lang->line("title_edit_project") ?></li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open(uri_string(), 'role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?= $this->lang->line("label_project_title") ?></label>
                            <?php echo form_input($name); ?>
                        </div>

                        <div class="form-group">
                            <label><?= $this->lang->line("label_project_description") ?></label>
                            <?php echo form_textarea($description); ?>
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-primary"><?= $this->lang->line("button_save_changes") ?></button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                    <?php echo form_close(); ?>

                </div>
            </div>

        </div>
    </div>
</div>
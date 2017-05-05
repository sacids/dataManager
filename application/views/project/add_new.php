<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add new project</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Manage Projects</a></li>
                <li class="active">Add new project</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open('projects/add_new', 'role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Title</label>
                            <?php echo form_input($name); ?>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <?php echo form_textarea($description); ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                    <?php echo form_close(); ?>

                </div>
            </div>

        </div>
    </div>
</div>
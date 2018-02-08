<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Import message file</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Import file</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>
                    <?php echo form_open_multipart('feedback/whatsapp/import', 'role="form"'); ?>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Message File</label>
                            <?php echo form_input($txt_file); ?>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </div>

                    <div class="form-group"></div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


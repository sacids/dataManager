<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Import message file</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('feedback/whatsapp/message_list') ?>">Messages</a></li>
                <li class="active">Import file</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open_multipart('feedback/whatsapp/import', 'role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Message File</label>
                            <?= form_input($txt_file); ?>
                        </div>


                        <div class="form-group">
                            <?= form_submit('submit', 'Import', 'class="btn btn-primary btn-sm"') ?>
                            <?= anchor('feedback/whatsapp/message_list', 'Cancel', 'class="btn btn-warning btn-sm"') ?>
                        </div>
                    </div><!--./col-sm-6 -->
                    <?= form_close(); ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div><!--./row -->
</div><!--./container -->


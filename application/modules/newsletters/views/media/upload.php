<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Upload Media</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('newsletters/mediaManager/lists') ?>">Medias</a></li>
                <li class="active">Upload Media</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open_multipart('newsletters/media/upload', 'role="form"'); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Media <span style="color: red;">*</span></label>
                                <?= form_upload('attachment[]', '', 'multiple class="form-control"') ?>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= form_submit('submit', 'Upload', array('class' => "btn btn-primary")); ?>
                                <?= anchor('newsletters/media/lists', 'Cancel', 'class="btn btn-warning"') ?>
                            </div> <!-- /form-group -->
                        </div>
                    </div><!--./row -->
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Access Control</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/accesscontrol') ?>">Access Control</a></li>
                <li class="active">Edit Access Control</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open(uri_string()) ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ACL name <span style="color: red">*</span></label>
                                    <?= form_input($name) ?>
                                </div>
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <?= form_textarea($description) ?>
                                </div>
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                    <?= anchor('auth/accesscontrol', 'Cancel', 'class="btn btn-warning"') ?>
                                </div> <!-- /form-group -->
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->
                        <?= form_close() ?>
                    </div>
                    <!--./pure-form -->

                </div>
                <!--./col-sm-12 -->
            </div>
            <!--./row -->
        </div>
    </div>
    <!--./row -->
</div>
<!--./container -->
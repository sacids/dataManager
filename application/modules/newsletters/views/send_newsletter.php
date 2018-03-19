<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Send NewsLetter</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Send Newsletter</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open('newsletters/send_newsletter'); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Edition</label>
                                <?php
                                $edition_options = array();
                                foreach ($edition_list as $value) {
                                    $edition_options[$value->id] = $value->title;
                                }
                                $edition_options = array('' => 'Choose edition') + $edition_options;
                                ?>
                                <?= form_dropdown("edition_id", $edition_options, set_value("edition_id"), 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Message <span style="color: red;">*</span></label>
                                <?= form_textarea($message); ?>
                            </div>
                        </div><!--./col-sm-6-->
                    </div><!--./row-->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= form_submit('submit', 'Send', 'class="btn btn-primary"') ?>
                            </div>
                        </div><!--./col-sm-6-->
                    </div><!--./row-->
                    <?= form_close(); ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>


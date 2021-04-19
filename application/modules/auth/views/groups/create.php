<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Create New</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('auth/groups/lists') ?>">Roles</a></li>
                <li class="breadcrumb-item active">Create new</li>
            </ol>

            <div class="row">
                <div class="col-lg-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open("auth/groups/create"); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role <span style="color: red;">*</span></label>
                                    <?= form_input($group_name); ?>
                                    <span class="red"><?= form_error('group_name'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Description <span style="color: red;">*</span></label>
                                    <?= form_textarea($description); ?>
                                    <span class="red"><?= form_error('description'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?= form_submit('submit', 'Save', array('class' => "btn btn-primary btn-sm")); ?>
                                    <?= anchor('auth/groups/lists', 'Cancel', 'class="btn btn-danger btn-sm"') ?>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-lg-12 -->
            </div>
            <!--./form -->

        </div>
    </div>

</div>
<!-- /.container-fluid -->
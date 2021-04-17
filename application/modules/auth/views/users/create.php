<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Register New</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('auth/users/lists') ?>">Users</a></li>
                <li class="breadcrumb-item active">Register new user</li>
            </ol>

            <div class="row">
                <div class="col-lg-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open('auth/users/create'); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name <span style="color: red;">*</span></label>
                                    <?php echo form_input($first_name); ?>
                                    <span class="red"><?= form_error('first_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last name <span style="color: red;">*</span></label>
                                    <?php echo form_input($last_name); ?>
                                    <span class="red"><?= form_error('last_name'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span style="color: red;">*</span></label>
                                    <?php echo form_input($email); ?>
                                    <span class="red"><?= form_error('email'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <?php echo form_input($phone); ?>
                                    <span class="red"><?= form_error('phone'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="title">Login Information</h5>
                            </div>
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>User Groups <span style="color: red;">*</span></label><br />
                                    <table>
                                        <tr>
                                            <?php
                                            $serial = 0;
                                            if (isset($groups) && $groups) {
                                                foreach ($groups as $group) {
                                                    if (($serial % 5) == 0) {
                                                        echo '</tr><tr>';
                                                    } ?>
                                                    <td>
                                                        <span id="grp-<?= $group->id ?>">
                                                            <input type="checkbox" name="groups_ids[]" value="<?= $group->id; ?>" <?= set_checkbox('groups_ids[]', $group->id); ?>>
                                                            <?= $group->description; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    </td>
                                            <?php $serial++;
                                                }
                                            } ?>
                                            <span class="red"><?= form_error('groups_ids[]'); ?></span>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username <span style="color: red;">*</span></label>
                                    <?php echo form_input($identity); ?>
                                    <span class="red"><?= form_error('identity'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password <span style="color: red;">*</span></label>
                                    <?php echo form_password($password); ?>
                                    <span class="red"><?= form_error('password'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password <span style="color: red;">*</span></label>
                                    <?php echo form_password($password_confirm); ?>
                                    <span class="red"><?= form_error('password_confirm'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                    <?= anchor('auth/users/lists', 'Cancel', 'class="btn btn-danger"') ?>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-lg-12 -->
            </div>
            <!--./row -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->
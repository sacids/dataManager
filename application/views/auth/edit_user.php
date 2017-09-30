<div class="container" id="content-middle">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit user</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('auth/list_user') ?>">Manage users</a></li>
                <li class="active">Edit user</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open(uri_string(), 'role="form"'); ?>
                    <div class="col-sm-8">

                        <input type="hidden" id="base_url" name="base_url" value="<?= base_url() ?>"/>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name <span style="color: red;">*</span></label>
                                    <?php echo form_input($first_name); ?>
                                </div> <!-- /form-group -->
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last name <span style="color: red;">*</span></label>
                                    <?php echo form_input($last_name); ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span style="color: red;">*</span></label>
                                    <?php echo form_input($email); ?>
                                </div> <!-- /form-group -->
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <?php echo form_input($phone); ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>District <span style="color: red;">*</span></label>
                                    <?php
                                    $district_options = array();
                                    foreach ($district_list as $v) {
                                        $district_options[$v->id] = $v->name;
                                    }
                                    $district_options = array('' => 'Choose district') + $district_options;
                                    echo form_dropdown('district', $district_options, set_value('district', $user->district), 'class="form-control" id="district" onchange="suggest_facilities();"');
                                    ?>
                                </div> <!-- /form-group -->
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Health Facility <span style="color: red;">*</span></label>
                                    <?php
                                    $facility_options = array();
                                    foreach ($facilities_list as $v) {
                                        $facility_options[$v->id] = $v->name;
                                    }
                                    $facility_options = array('' => 'Choose facility') + $facility_options;
                                    echo form_dropdown('facility', $facility_options, set_value('facility', $user->facility), 'class="form-control" id="facility"');
                                    ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Username <span style="color: red;">*</span></label>
                                        <?php echo form_input($identity); ?>
                                    </div>
                                </div> <!-- /form-group -->
                            </div>

                            <div class="col-sm-6">
                                <?php if ($this->ion_auth->is_admin()): ?>
                                    <div class="form-group">
                                        <label>Groups <span style="color: red;">*</span></label><br/>
                                        <?php foreach ($groups as $group): ?>
                                            <?php
                                            $gID = $group['id'];
                                            $checked = null;
                                            $item = null;
                                            foreach ($currentGroups as $grp) {
                                                if ($gID == $grp->id) {
                                                    $checked = ' checked="checked"';
                                                    break;
                                                }
                                            }
                                            ?>
                                            <input type="checkbox" name="groups[]"
                                                   value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                                            <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password <span style="color: red;">*</span></label>
                                    <?php echo form_password($password); ?>
                                </div> <!-- /form-group -->
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password <span style="color: red;">*</span></label>
                                    <?php echo form_password($password_confirm); ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo form_submit('submit', 'Edit user', array('class' => "btn btn-primary")); ?>
                                    <?= anchor('auth/users_list', 'Cancel', 'class="btn btn-warning"') ?>
                                </div> <!-- /form-group -->
                            </div>
                        </div> <!-- /.row -->
                    </div>

                    <?php echo form_hidden('id', $user->id); ?>
                    <?php echo form_hidden($csrf); ?>

                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>
</div>


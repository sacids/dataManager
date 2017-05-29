<section>
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
                        <div class="pure-form">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name <span style="color: red;">*</span></label>
                                    <?php echo form_input($first_name); ?>
                                </div>

                                <div class="form-group">
                                    <label>Last name <span style="color: red;">*</span></label>
                                    <?php echo form_input($last_name); ?>
                                </div>

                                <div class="form-group">
                                    <label>Email <span style="color: red;">*</span></label>
                                    <?php echo form_input($email); ?>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <?php echo form_input($phone); ?>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username <span style="color: red;">*</span></label>
                                    <?php echo form_input($identity); ?>
                                </div>

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
                                <?php endif ?>

                                <div class="form-group">
                                    <label>Password</label>
                                    <?php echo form_password($password); ?>
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <?php echo form_password($password_confirm); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo form_submit('submit', 'Edit user', array('class' => "btn btn-primary")); ?>
                                    <?php echo form_submit('cancel', 'Cancel', array('class' => "btn btn-warning")); ?>
                                </div>
                            </div>

                            <div class="form-group"></div>
                        </div>

                        <?php echo form_hidden('id', $user->id); ?>
                        <?php echo form_hidden($csrf); ?>

                        <?php echo form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


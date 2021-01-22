<section class="bg-grey">
    <div class="container" style="min-height: 450px;">
        <div class="row">
            <div class="col-md-4 col-sm-3 col-xs-12 col-lg-4"></div>
            <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
                <div class="default-padding">

                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <i class="fa fa-user-plus"></i>
                            SIGN UP
                        </div>

                        <div class="panel-body">
                            <?php if ($message != "") {
                                echo '<span class="red">' . $message . '</span>';
                            } ?>

                            <?= form_open('auth/sign_up', 'class="form-horizontal"') ?>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>First name <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <?= form_input($first_name); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>Last name <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <?= form_input($last_name); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>Organization <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                        <?= form_input($organization); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>Email <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <?= form_input($email); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>Phone <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <?= form_input($phone); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>Password <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <?= form_input($password); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>Password Confirm<span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <?= form_input($password_confirm); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <?= form_hidden('group[]', '8'); ?>

                            <div class="form-group last">
                                <div class="col-lg-6">
                                    <?= form_submit('submit', 'Sign up', array('class' => "btn btn-maroon btn-large btn-block")); ?>
                                </div>
                            </div><!-- form-group -->
                            <?= form_close() ?>

                        </div><!--./panel-body -->
                    </div><!--./panel -->
                </div>
            </div><!--./col-md-4 -->
            <div class="col-md-2"></div>
        </div><!--./row -->
    </div><!--./container -->
</section>
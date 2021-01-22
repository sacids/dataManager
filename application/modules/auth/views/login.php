<section class="bg-grey">
    <div class="container" style="min-height: 450px;">
        <div class="row">
            <div class="col-md-4 col-sm-3 col-xs-12 col-lg-4"></div>
            <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
                <div class="default-padding">

                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <i class="fa fa-sign-in"></i>
                            LOGIN
                        </div>

                        <div class="panel-body">
                            <?php if ($message != "") {
                                echo '<span class="red">' . $message . '</span>';
                            } ?>

                            <?= form_open('auth/login', 'class="form-horizontal"') ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>Username <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <?= form_input($identity); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <?= form_input($password); ?>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label class="">
                                            <input class="" type="checkbox">Remember me</label>
                                    </div>
                                </div>
                            </div><!--./form-group -->

                            <div class="form-group last">
                                <div class="col-lg-12">
                                	<button type="submit" class="btn btn-maroon btn-block text-uppercase">
                                    Login <i class="fa fa-chevron-circle-right"></i>
                                </button>
                                </div>
                            </div><!-- form-group -->
                            <?= form_close() ?>

                        </div><!--./panel-body -->
                        <div class="panel-footer">
                            <a href="#">Forgot password</a>
                        </div><!--./panel-footer -->
                    </div><!--./panel -->
                </div>
            </div><!--./col-md-4 -->
            <div class="col-md-3"></div>
        </div><!--./row -->
    </div><!--./container -->
</section>
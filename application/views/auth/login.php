<section>
    <div class="container">
        <div class="sign-up row">

            <div class="left-col col-lg-7">
                <h2>AFYADATA - Taarifa kwa wakati!</h2>

                <p>Afyadata Manager is a tool that analyzes all the data collected from the field
                    and intelligently sends feedback to the data collector and sends an alert to higher authority
                    officials if any abnormal pattern is discovered in the data collected.</p>
                <p>This tool provides a graphical
                    user interface for involved health stakeholders to analyze and visualizing data collected via
                    Afyadata
                    mobile app for android.</p>
            </div>

            <div class="right-col col-lg-5">
                <form action="<?php echo site_url('auth/login'); ?>" class="form-horizontal" role="form"
                      method="post" accept-charset="utf-8">
                    <div class="pure-form">
                        <h2>Login to Afyadata</h2>
                        <div class="col-sm-12">
                            <div class="row">
                                <?php if (validation_errors() != "") {
                                    echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                                } else if ($message != "") {
                                    echo $message;
                                } ?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= form_input($identity) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= form_password($password) ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label class="">
                                            <input class="" type="checkbox">Remember me</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8">
                                    <?php echo form_submit('submit', 'Login', array('class' => "btn btn-maroon btn-large btn-block")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

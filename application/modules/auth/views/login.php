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

                        <?php if ($message != "") {
                            echo '<div style="color: red; font-size: 11px;">' . $message . '</div>';
                        } ?>

                        <div class="col-lg-12" style="margin-top: 10px;">

                            <div class="form-group">
                                <?= form_input($identity) ?>
                            </div>
                            <div class="form-group">
                                <?= form_password($password) ?>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="">
                                        <input class="" type="checkbox">Remember me</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo form_submit('submit', 'Login', array('class' => "btn btn-maroon")); ?>
                            </div>
                        </div>
                        <div class="form-group"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

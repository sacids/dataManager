

<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

  <title>Sacids Research Portal</title>

  <meta charset="utf-8" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" TYPE="image/png" href="<?php echo base_url();?>favicon.png">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/public/login/reset.css" type="text/css" media="screen" title="no title" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/public/login/text.css" type="text/css" media="screen" title="no title" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/public/login/buttons.css" type="text/css" media="screen" title="no title" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/public/login/login.css" type="text/css" media="screen" title="no title" />
</head>

<body>

<div id="login">
  <center><img src="<?php echo base_url();?>assets/public/images/sacidsLogo.jpg" width="180" /></center>
  <div id="login_panel">
    <?php if($message != ''):?>
      <div id="infoMessage"><?php echo $message;?></div>
    <?php endif;?>
    <form action="<?php echo site_url('auth/login');?>" method="post" accept-charset="utf-8">
      <div class="login_fields">
        <div class="field">
          <label for="identity">Username</label>
          <input type="text" name="identity"  id="identity"  placeholder="username" value="<?php echo set_value('identity');?>" />
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input type="password" name="password"  id="password"  placeholder="password" <?php echo set_value('password');?> />
        </div>
      </div> <!-- .login_fields -->

      <div class="login_actions">
        <button type="submit" class="btn btn-primary btn-small" tabindex="3">Login</button>
      </div>
    </form>
  </div> <!-- #login_panel -->
</div> <!-- #login -->

<script src="<?php echo base_url();?>javascripts/all.js"></script>


</body>
</html>

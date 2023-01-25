<link rel="stylesheet" type="text/css" href="<?= base_url('assets/public/css/chat.css'); ?>">
<script src="<?= base_url('assets/public/js/chat.js '); ?>"></script>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Chats</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('feedback/lists') ?>">Messages</a></li>
                <li class="active">Chats</li>
            </ol>



            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#chats">Chats</a></li>
                        <li><a data-toggle="tab" href="#data-details">Submitted Data</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="chats" class="tab-pane fade in active">
                            <ol class="chat">
                                <?php foreach ($feedback as $values) {
                                    if ($values->sender == "user") $class = "self";
                                    else $class = "other"; ?>
                                    <li class="<?php echo $class; ?>">
                                        <div class="msg">
                                            <p><?= $values->message ?></p>
                                            <span><?php echo $values->sender_name; ?></span>
                                            <time><?= date('H:i:s', strtotime($values->date_created)) ?></time>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ol>
                            <!--./ol -->

                            <?= form_open('', 'class="feedback_form" id="form"') ?>
                            <input class="textarea" type="text" name="message" id="message" placeholder="Type feedback here!" required />
                            <button type="submit" name="submit" class="submit btn btn-primary">Send
                            </button>
                            <?= form_close() ?>
                        </div>
                        <!--./feedback -->

                        <div id="data-details" class="tab-pane fade in">
                            <div class="pull-right" style="margin: 10px 0;">
                                <a id="update-data" title="Update" class="btn btn-primary text-medium btn-sm" instance-id="1">
                                    <span class="text-capitalize">
                                        <i class="fa fa-pencil"></i> Update</span>
                                </a>&nbsp;&nbsp;
                            </div><!--./pull-right -->




                            <?php if (isset($form_data) && $form_data) { ?>
                                <table class="table table-bordered">
                                    <?php foreach ($form_data as $val) { ?>
                                        <tr>
                                            <td><?= $val['label'] ?></td>
                                            <td><?= $val['value'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } else {
                                echo "<div class='alert alert-warning'>Nothing to display</div>";
                            } ?>
                        </div>
                        <!--./data -->
                    </div>
                    <!--./tab-content -->
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->
        </div>
        <!--./col-sm-12 -->
    </div>
    <!--./row -->
</div>
<!--./container -->
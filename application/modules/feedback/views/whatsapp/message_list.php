<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Whatsapp Message List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Whatsapp message list</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('feedback/whatsapp/import', '<i class="fa fa-upload"></i> Import Messages', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>

                            <div class="pull-right">
                                <?= form_open("feedback/whatsapp/message_list", 'class="form-inline" role="form"'); ?>

                                <div class="form-group">
                                    <?= form_input(array('name' => 'start_date', 'id' => 'start_date', 'class' => 'form-control', 'placeholder' => 'Start date')) ?>
                                </div>

                                <div class="form-group">
                                    <?= form_input(array('name' => 'end_date', 'id' => 'end_date', 'class' => 'form-control', 'placeholder' => 'End date')) ?>
                                </div>

                                <div class="form-group">
                                    <?= form_input(array('name' => 'keyword', 'id' => 'keyword', 'class' => 'form-control', 'placeholder' => 'Keyword..')) ?>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <?= form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($messages) && $messages) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th class="col-md-2">Sent Date</th>
                                <th class="col-md-2">Full name</th>
                                <th class="col-md-8">Message</th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($messages as $message) { ?>
                                <tr>
                                    <td><?php echo date('j F Y, H:i:s', strtotime($message->date_sent_received)); ?></td>
                                    <td><?php echo $message->fullname; ?></td>
                                    <td><?php echo $message->message; ?></td>
                                </tr>
                                <?php $serial++;
                            } ?>
                        </table>
                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No any message found', 'warning');
                    } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div><!--./row -->
</div><!--./container -->

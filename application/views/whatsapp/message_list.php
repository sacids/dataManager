<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">List Message</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List message</li>
            </ol>


            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <div class="pull-left" style="margin-bottom: 10px;">
                        <?php echo anchor("whatsapp/csv_export_data/", '<img src="' . base_url() . 'assets/public/images/csv-export.png" height="30px"/>') ?>
                    </div>
                    <div class="pull-right" style="margin-bottom: 10px;">
                        <?php echo form_open("whatsapp/message_list", 'class="form-inline" role="form"'); ?>

                        <div class="form-group">
                            <input name="start_date" id="start_date" class="form-control" placeholder="Start Date"/>
                        </div>

                        <div class="form-group">
                            <input name="end_date" id="end_date" class="form-control" placeholder="End Date"/>
                        </div>

                        <div class="form-group">
                            <input name="keyword" id="keyword" class="form-control" placeholder="Enter Keyword"/>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <?php echo form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                        <?php echo validation_errors(); ?>
                    </div>

                    <?php if (!empty($messages)) { ?>

                        <table class="table table-striped table-responsive table-hover">
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
                    <?php } else { ?>
                        <div class="fail_message">Nothing to display here!</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

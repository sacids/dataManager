<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">List Feedback</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List feedback</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-right" style="margin-bottom: 10px;">

                        <?php echo form_open("feedback/lists", 'class="form-inline" role="form"'); ?>

                        <div class="form-group">

                            <?php
                            $data_name = array(
                                'name' => 'name',
                                'id' => 'name',
                                'class' => "form-control",
                                'placeholder' => "Search by form title"
                            );
                            echo form_input($data_name); ?>
                        </div>

                        <div class="form-group">
                            <?php
                            $username = array(
                                'name' => 'username',
                                'id' => 'username',
                                'class' => "form-control",
                                'placeholder' => "Search by username"
                            );
                            echo form_input($username); ?>
                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <?php echo form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                        <?php echo validation_errors(); ?>
                    </div>

                    <?php if (!empty($feedback)) { ?>

                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <th width="15%"><?php echo $this->lang->line("label_form_name"); ?></th>
                                <th width="15%"><?php echo $this->lang->line("label_user"); ?></th>
                                <th width="50%"><?php echo $this->lang->line("label_message"); ?></th>
                                <th width="12%"><?php echo $this->lang->line("label_feedback_date"); ?></th>
                                <th width="6%"></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($feedback as $value) { ?>
                                <tr>
                                    <td><?php echo $value->title; ?></td>
                                    <td><?php echo ucfirst($value->first_name) . ' ' . ucfirst($value->last_name); ?></td>
                                    <td><?php echo ucfirst($value->message); ?></td>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($value->date_created)); ?></td>
                                    <td>
                                        <?php echo anchor("feedback/user_feedback/" . $value->instance_id, "Conversation", 'class = "btn btn-primary btn-xs"'); ?>
                                    </td>
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
                        <div class="fail_message">You don't have any recent chat.</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
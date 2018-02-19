<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Feedback Messages List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Feedback List</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-right" style="margin-bottom: 10px;">

                        <?= form_open("feedback/lists", 'class="form-inline" role="form"'); ?>
                        <div class="form-group">
                            <?= form_input(array('name' => 'name', 'id' => 'name', 'class' => "form-control", 'placeholder' => "Form title")); ?>
                        </div><!--./form-group -->

                        <div class="form-group">
                            <?= form_input(array('name' => 'username', 'id' => 'username', 'class' => "form-control", 'placeholder' => "Username")); ?>
                        </div><!--./form-group -->


                        <div class="form-group">
                            <div class="input-group">
                                <?= form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                            </div>
                        </div><!--./form-group -->
                        <?= form_close(); ?>
                    </div>

                    <?php if (isset($feedback_list) && $feedback_list) { ?>

                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="80%">Feedback Description</th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($feedback_list as $value) { ?>
                                <tr>
                                    <td>
                                        <?= '<h5>' . strtoupper($value->title) . '</h5>'; ?>
                                        <?= '<p><h5 class="text-primary">' . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . '</h5></p>'; ?>
                                        <?= '<p>' . ucfirst($value->message) . '</p>' ?>
                                        <?= '<i class="fa fa-clock-o"></i><span class="text-primary">' . date('jS F, Y H:i:s', strtotime($value->date_created)) . '</span>'; ?>
                                        <span style="float: right"><?= anchor("feedback/user_feedback/" . $value->instance_id, '<i class="fa fa-comments-o fa-lg"></i>', ''); ?></span>
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
                    <?php } else {
                        echo display_message('You don\'t have any recent chat.', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
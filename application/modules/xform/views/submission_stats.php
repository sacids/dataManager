<div class="container body-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">CHW Submission Stats : <?= $form->title ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projects</a></li>
                <li><a href="<?= site_url('projects/forms/' . $project->id) ?>"><?= $project->title ?></a></li>
                <li class="active"><?= $form->title ?></li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-md-12 col-12">
                    <?php if (isset($data_collectors) && $data_collectors) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered" cellspacing="0" cellpadding="0">
                            <tr>
                                <th width="3%">#</th>
                                <th width="60%">Full Name</th>
                                <th width="10%">Username</th>
                                <th width="10%">No. of Submission</th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($data_collectors as $val) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $val->first_name . ' ' . $val->last_name; ?></td>
                                    <td><?= $val->username; ?></td>
                                    <td><?= number_format($val->submission) ?></td>
                                </tr>
                            <?php $serial++;
                            } ?>
                        </table>
                        <?php if (!empty($links)) : ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>

                    <?php } else { ?>
                        <div class="fail_message">Nothing found</div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
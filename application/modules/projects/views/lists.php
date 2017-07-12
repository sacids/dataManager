<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">List Projects</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List projects</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <?php if (count($project_list) > 0) { ?>
                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <th width="10%">Title</th>
                                <th width="65%">Description</th>
                                <th width="15%">Created date</th>
                                <th width="8%"></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($project_list as $value) { ?>
                                <tr>
                                    <td><?php echo $value->title; ?></td>
                                    <td><?php echo $value->description; ?></td>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($value->created_at)); ?></td>
                                    <td>
                                        <?php echo anchor("projects/edit/" . $value->id, "Edit"); ?>
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
                        <div class="fail_message">You don't have any project</div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
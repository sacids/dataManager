<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Newsletter Editions</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Newsletter Editions</li>
            </ol>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('newsletters/add_new_edition', '<i class="fa fa-plus"></i> Add new edition', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($edition_list) && $edition_list) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="5%"></th>
                                <th width="60%">Title</th>
                                <th width="15%">Created Date</th>
                                <th width="20%">Action</th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($edition_list as $value) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $value->title ?></td>
                                    <td><?= date('jS F, Y', strtotime($value->date_created)) ?></td>
                                    <td>
                                        <?= anchor("newsletters/edit_edition/" . $value->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"') ?>
                                        <?= anchor("newsletters/delete_edition/" . $value->id, '<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs delete"'); ?>
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
                        echo display_message('You don\'t have any edition.', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
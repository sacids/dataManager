<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Campaign List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Campaign List</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('campaign/add_new', '<i class="fa fa-plus"></i> Add new campaign', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($campaign_list) && count($campaign_list) > 0) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th width="15%"><?= $this->lang->line("label_campaign_title"); ?></th>
                                <th width="8%"><?= $this->lang->line("label_campaign_type"); ?></th>
                                <th width="16%"><?= $this->lang->line("label_form_name"); ?></th>
                                <th width="8%"><?= $this->lang->line("label_campaign_icon"); ?></th>
                                <th width="15%"><?= $this->lang->line("label_campaign_created_date"); ?></th>
                                <th width="12%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($campaign_list as $campaign) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $campaign->title; ?></td>
                                    <td><?= ucfirst($campaign->type); ?></td>
                                    <td><?php if (count($campaign->xform) > 0)
                                            echo $campaign->xform->title;
                                        else
                                            echo ''; ?></td>
                                    <td><?= anchor('campaign/change_icon/' . $campaign->id, '<img src="' . base_url() . 'assets/forms/data/images/' . $campaign->icon . '" height="30"/>'); ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($campaign->date_created)); ?></td>
                                    <td>
                                        <?= anchor("campaign/edit/" . $campaign->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"') ?>
                                        <?= anchor("campaign/delete/" . $campaign->id, '<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs delete"'); ?>
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
                        echo display_message('No any campaign found', 'warning');
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>
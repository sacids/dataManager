<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">List campaign</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List campaign</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <?php if (count($campaign_list) > 0) { ?>
                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <th width="20%"><?php echo $this->lang->line("label_campaign_title"); ?></th>
                                <th width="10%"><?php echo $this->lang->line("label_campaign_type"); ?></th>
                                <th width="20%"><?php echo $this->lang->line("label_form_name"); ?></th>
                                <th width="8%"><?php echo $this->lang->line("label_campaign_icon"); ?></th>
                                <th width="15%"><?php echo $this->lang->line("label_campaign_created_date"); ?></th>
                                <th width="8%"><?php echo $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($campaign_list as $campaign) { ?>
                                <tr>
                                    <td><?= $campaign->title; ?></td>
                                    <td><?= ucfirst($campaign->type); ?></td>
                                    <td><?= $campaign->xform->title; ?></td>
                                    <td><?= anchor('campaign/change_icon/' . $campaign->id, '<img src="' . base_url() . 'assets/forms/data/images/' . $campaign->icon . '" height="30"/>'); ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($campaign->date_created)); ?></td>
                                    <td>
                                        <?= anchor("campaign/edit/" . $campaign->id, "Edit"); ?> |
                                        <?= anchor("campaign/delete/" . $campaign->id, "Delete", "class='delete'"); ?>
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
                        <div class="fail_message">You don't have any campaign</div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
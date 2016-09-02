<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <h3>Campaign List</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>


            <div class="col-sm-12">

                <?php if (!empty($campaigns)) { ?>

                    <table class="table table-striped table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo $this->lang->line("label_campaign_title"); ?></th>
                            <th><?php echo $this->lang->line("label_campaign_type"); ?></th>
                            <th><?php echo $this->lang->line("label_form_name"); ?></th>
                            <th><?php echo $this->lang->line("label_campaign_icon"); ?></th>
                            <th><?php echo $this->lang->line("label_campaign_created_date"); ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($campaigns as $campaign) { ?>
                            <tr>
                                <td><?php echo $campaign->c_title; ?></td>
                                <td><?php echo $campaign->type; ?></td>
                                <td><?php echo $campaign->x_title; ?></td>
                                <td><?php echo anchor('campaign/change_icon/' . $campaign->id, $campaign->icon); ?></td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($campaign->date_created)); ?></td>
                                <td>
                                    <?php echo anchor("campaign/edit/" . $campaign->id, "Edit"); ?> |
                                    <?php echo anchor("campaign/campaign_list", "Delete", "class='delete'"); ?>
                                </td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>

                <?php } else { ?>
                    <div class="fail_message">You don't have any campaign to display</div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>
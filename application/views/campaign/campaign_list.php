<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

    <?php
    if ($this->session->flashdata('message') != '') {
        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
    } ?>

    <div class="table_list">

        <?php if (!empty($campaigns)) { ?>

            <table class="table" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Title</th>
                    <th>Form Id</th>
                    <th>Description</th>
                    <th>End date</th>
                    <th><?php echo $this->lang->line("label_action"); ?></th>
                </tr>

                <?php
                $serial = 1;
                foreach ($campaigns as $campaign) { ?>
                    <tr>
                        <td><?php echo $campaign->title; ?></td>
                        <td><?php echo $campaign->form_id; ?></td>
                        <td><?php echo $campaign->description; ?></td>
                        <td><?php //echo date('d-m-Y H:i:s', strtotime($form->end_date)); ?></td>
                        <td>
                            <?php echo anchor("campaign/edit_campaign/" . $campaign->id, "Edit"); ?> |
                            <?php echo anchor("campaign/delete_campaign/" . $campaign->id, "Delete", "class='delete'"); ?>
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
<div id="grid_padding" class="grid_11">

    <?php
    if ($this->session->flashdata('message') != '') {
        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
    } ?>

    <div class="table_list">

        <?php if (!empty($feedback)) { ?>

            <table class="table" cellspacing="0" cellpadding="0">
                <tr>
                    <th></th>
                    <th>Form Id</th>
                    <th>user</th>
                    <th>Last Message</th>
                    <th>date</th>
                    <th><?php echo $this->lang->line("label_action"); ?></th>
                </tr>

                <?php
                $serial = 1;
                foreach ($feedback as $value) { ?>
                    <tr>
                        <td><?php echo $value->form_id; ?></td>
                        <td><?php echo $value->user_id; ?></td>
                        <td><?php echo $value->message; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($value->date_created)); ?></td>
                        <td>
                            <?php echo anchor("feedback/user_feedback/" . $value->user_id."/".$value->form_id, "Conversation"); ?>
                        </td>
                    </tr>
                    <?php $serial++;
                } ?>
            </table>

        <?php } else { ?>
            <div class="fail_message">You don't have any feedback to display</div>
        <?php } ?>
    </div>
</div>
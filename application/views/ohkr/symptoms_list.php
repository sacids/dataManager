<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="table_list">

                <?php if (!empty($symptoms)) { ?>

                    <table class="table" cellspacing="0" cellpadding="0">
                        <tr>
                            <th><?php echo $this->lang->line("label_symptom_name"); ?></th>
                            <th><?php echo $this->lang->line("label_description"); ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($symptoms as $symptom) { ?>
                            <tr>
                                <td><?php echo $symptom->name; ?></td>
                                <td><?php echo $symptom->description; ?></td>
                                <td>
                                    <?php echo anchor("ohkr/edit_symptom/".$symptom->id, "Edit"); ?> |
                                    <?php echo anchor("ohkr/delete_symptom/".$symptom->id, "Delete", "class='delete'"); ?>
                                </td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>

                <?php } else { ?>
                    <div class="fail_message">No symptom has been added</div>
                <?php } ?>
            </div>
        </div>
    </div>

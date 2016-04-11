<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="table_list">

                <?php if (!empty($species)) { ?>

                    <table class="table" cellspacing="0" cellpadding="0">
                        <tr>
                            <th><?php echo $this->lang->line("label_specie_name"); ?></th>
                            <th><?php echo $this->lang->line("label_date_created"); ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($species as $specie) { ?>
                            <tr>
                                <td><?php echo $specie->name; ?></td>
                                <td><?php //echo date('d-m-Y H:i:s', strtotime($specie->date_created)); ?></td>
                                <td>
                                    <?php echo anchor("#", "Edit"); ?> |
                                    <?php echo anchor("#", "Delete", "class='delete'"); ?>
                                </td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>

                <?php } else { ?>
                    <div class="fail_message">No species has been added</div>
                <?php } ?>
            </div>
        </div>
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3><?php echo $disease->name;?> Symptoms</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <a href="<?php echo site_url('ohkr/add_disease_symptom/' . $disease->id); ?>"
               class="btn btn-small btn-primary">Add Symptoms</a>
            <br /><br />
            <div class="table_list">

                <?php if (!empty($symptoms)) { ?>

                    <table class="table" cellspacing="0" cellpadding="0">
                        <tr>
                            <th>Species</th>
                            <th><?php echo $this->lang->line("label_symptom_name"); ?></th>
                            <th>Importance (%)</th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($symptoms as $symptom) { ?>
                            <tr>
                                <td><?php echo $symptom->specie_name; ?></td>
                                <td><?php echo $symptom->symptom_name; ?></td>
                                <td><?php echo $symptom->importance; ?></td>
                                <td>
                                    <?php echo anchor("ohkr/edit_disease_symptom/".$disease->id."/".$symptom->id, "Edit"); ?> |
                                    <?php echo anchor("ohkr/delete_disease_symptom/".$disease->id."/".$symptom->id, "Delete", "class='delete'"); ?>
                                </td>
                                <td>
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

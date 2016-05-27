<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">


            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <h3>Diseases List</h3>
                <?php if (!empty($diseases)) { ?>

                    <table class="table table-striped table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo $this->lang->line("label_disease_name"); ?></th>
                            <th><?php echo $this->lang->line("label_specie_name"); ?></th>
                            <th><?php echo $this->lang->line("label_description"); ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($diseases as $disease) { ?>
                            <tr>
                                <td><?php echo $disease->disease_title; ?></td>
                                <td><?php echo $disease->specie_title; ?></td>
                                <td><?php echo $disease->description; ?></td>
                                <td>

                                    <?php echo anchor("ohkr/edit_disease/" . $disease->id, "Edit"); ?> |
                                    <?php echo anchor("ohkr/delete_disease/" . $disease->id, "Delete", "class='delete'"); ?> |
                                    <?php echo anchor("ohkr/scd_list/" . $disease->id, "SCD"); ?>
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
                    <div class="fail_message">No disease has been added</div>
                <?php } ?>
            </div>
        </div>
    </div>

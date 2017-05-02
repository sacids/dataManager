<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Species List</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-6">

                <?php if (!empty($species)) { ?>

                    <table class="table table-striped table-responsive table-hover">
                        <tr>
                            <th><?php echo $this->lang->line("label_specie_name"); ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($species as $specie) { ?>
                            <tr>
                                <td><?php echo $specie->title; ?></td>
                                <td>
                                    <?php echo anchor("ohkr/edit_specie/" . $specie->id, "Edit"); ?> |
                                    <?php echo anchor("ohkr/delete_specie/" . $specie->id, "Delete", "class='delete'"); ?>
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
                    <div class="fail_message">No species has been added</div>
                <?php } ?>
            </div>
        </div>
    </div>

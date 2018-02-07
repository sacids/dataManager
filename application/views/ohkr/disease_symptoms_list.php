<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $disease->d_title; ?> clinical manifestation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List clinical manifestation</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <a href="<?php echo site_url('ohkr/add_disease_symptom/' . $disease->id); ?>"
                   class="btn btn-small btn-primary">Add clinical manifestation</a>
                <br/><br/>

                <?php if (!empty($symptoms)) { ?>

                    <table class="table table-striped table-responsive table-hover">
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
                                <td><?php echo $disease->s_title; ?></td>
                                <td><?php echo $symptom->symptom_title; ?></td>
                                <td><?php echo $symptom->importance; ?></td>
                                <td>
                                    <?php echo anchor("ohkr/edit_disease_symptom/" . $disease->id . "/" . $symptom->id, "Edit"); ?>
                                    |
                                    <?php echo anchor("ohkr/delete_disease_symptom/" . $disease->id . "/" . $symptom->id, "Delete", "class='delete'"); ?>
                                </td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>

                <?php } else { ?>
                    <div class="fail_message">No clinical manifestation has been added</div>
                <?php } ?>
            </div>
        </div>
    </div>

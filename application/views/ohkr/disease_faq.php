<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <h3>Frequently Asked Questions - <?php echo $disease->d_title; ?></h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <a href="<?php echo site_url('ohkr/add_disease_faq/' . $disease->id); ?>"
                   class="btn btn-small btn-primary">Add FAQ</a>
                <br/><br/>

                <?php if (!empty($faq)) { ?>

                    <table class="table table-striped table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo $this->lang->line("label_question") ?></th>
                            <th><?php echo $this->lang->line("label_answer") ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($faq as $value) { ?>
                            <tr>
                                <td><?php echo $value->question; ?></td>
                                <td><?php echo $value->answer; ?></td>
                                <td>
                                    <?php echo anchor("ohkr/edit_disease_faq/" . $disease->id . "/" . $value->id, "Edit"); ?>
                                    |
                                    <?php echo anchor("ohkr/delete_disease_faq/" . $disease->id . "/" . $value->id, "Delete", "class='delete'"); ?>
                                </td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>

                <?php } else { ?>
                    <div class="fail_message">No faq has been added</div>
                <?php } ?>
            </div>
        </div>
    </div>

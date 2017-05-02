<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add <?php echo $disease->d_title; ?> FAQ</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">

                <?php echo form_open('ohkr/add_disease_faq/' . $disease->id, 'class="form-horizontal" role="form"'); ?>


                <div class="form-group">
                    <label><?php echo $this->lang->line("label_question") ?> :</label>
                        <textarea class="form-control" name="question"
                                  id="question"><?php echo set_value('question'); ?></textarea>
                </div>
                <div class="error" style="color: red"><?php echo form_error('question'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_answer") ?> :</label>
                        <textarea class="form-control" name="answer"
                                  id="answer"><?php echo set_value('answer'); ?></textarea>
                </div>
                <div class="error" style="color: red"><?php echo form_error('answer'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>


                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Edit <?php echo $disease->d_title; ?> FAQ</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">

                <?php echo form_open('ohkr/edit_disease_faq/' . $disease->id. "/" . $faq->id,
                    'class="form-horizontal" role="form"'); ?>


                <div class="form-group">
                    <label><?php echo $this->lang->line("label_question") ?> :</label>
                        <textarea class="form-control" name="question"
                                  id="question"><?php echo $faq->question; ?></textarea>
                </div>
                <div class="error" style="color: red"><?php echo form_error('question'); ?></div>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_answer") ?> :</label>
                        <textarea class="form-control" name="answer"
                                  id="answer"><?php echo $faq->answer; ?></textarea>
                </div>
                <div class="error" style="color: red"><?php echo form_error('answer'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>


                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit <?php echo $disease->d_title; ?> Disease Symptom</h3>
            </div>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-8">
                <?php echo form_open('ohkr/edit_disease_symptom/' . $disease->id . "/" . $disease_symptom_id,
                    'class="form-horizontal" role="form"'); ?>

                <div class="form-group">
                    <label><?php echo $this->lang->line("label_symptom_name") ?> <span>*</span></label>
                    <select name="symptom" id="symptom" class="form-control">
                        <option value="<?php echo $symptom->id; ?>"><?php echo $symptom->title; ?></option>

                        <?php foreach ($symptoms as $symptom) { ?>
                            <option value="<?php echo $symptom->id; ?>"><?php echo $symptom->title; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="error" style="color: red"> <?php echo form_error('symptom'); ?></div>

                <div class="form-group">
                    <label>Importance (%) <span>*</span></label>
                    <input type="text" name="importance" placeholder="Enter importance" class="form-control"
                           value="<?php echo $importance; ?>">
                </div>
                <div class="error" style="color: red"><?php echo form_error('importance'); ?></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>


                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php echo form_open_multipart('ohkr/edit_disease_symptom/' . $disease->id."/".$disease_symptom_id, 'class="form-horizontal" role="form"'); ?>
            <h3>Edit <?php echo $disease->name; ?> Disease Symptom</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>


            <div class="form-group">
                <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                <select name="specie" id="specie" class="form-control">
                    <option value="<?php echo $specie->id;?>"><?php echo $specie->name;?></option>
                    <?php foreach ($species as $specie) { ?>
                        <option value="<?php echo $specie->id; ?>"><?php echo $specie->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php echo form_error('specie'); ?>

            <div class="form-group">
                <label><?php echo $this->lang->line("label_symptom_name") ?> <span>*</span></label>
                <select name="symptom" id="symptom" class="form-control">
                    <option value="<?php echo $symptom->id;?>"><?php echo $symptom->name;?></option>
                    <?php foreach ($symptoms as $symptom) { ?>
                        <option value="<?php echo $symptom->id; ?>"><?php echo $symptom->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php echo form_error('symptom'); ?>

            <div class="form-group">
                <label>Importance (%) <span>*</span></label>
                <input type="text" name="importance" placeholder="Enter importance" class="form-control"
                       value="<?php echo $importance; ?>">
            </div>
            <?php echo form_error('importance'); ?>


            <div class="form-group">
                <label>&nbsp; &nbsp; &nbsp;</label>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>


            <?php echo form_close(); ?>
        </div>
    </div>
</div>

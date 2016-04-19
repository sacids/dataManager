<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <?php echo form_open_multipart('ohkr/edit_specie/'.$specie->id, 'class="form-horizontal" role="form"'); ?>

            <h3>Edit Specie Details</h3>
            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>


            <div class="form-group">
                <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                <input type="text" name="specie" placeholder="Enter disease name" class="form-control"
                       value="<?php echo $specie->name; ?>">
            </div>
            <?php echo form_error('specie'); ?>

            <div class="form-group">
                <label>&nbsp; &nbsp; &nbsp;</label>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>



            <?php echo form_close(); ?>
        </div>
    </div>
</div>
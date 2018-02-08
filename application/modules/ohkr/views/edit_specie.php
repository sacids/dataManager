<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Edit specie</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Edit specie</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="col-sm-6">

                <?php echo form_open(uri_string(), 'role="form"'); ?>
                <div class="form-group">
                    <label><?php echo $this->lang->line("label_specie_name") ?> <span>*</span></label>
                    <input type="text" name="specie" placeholder="Enter specie title" class="form-control"
                           value="<?php echo $specie->title; ?>">
                </div>
                <?php echo form_error('specie'); ?>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add new specie</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/species') ?>">Species</a></li>
                <li class="active">Add new specie</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="pure-form">
                        <?php echo form_open('ohkr/species/add_new', 'role="form"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_specie_name") ?> <span class="red">*</span></label>
                                    <input type="text" name="specie" placeholder="Enter specie title" class="form-control" value="<?php echo set_value('specie'); ?>">
                                </div>
                                <div class="error" style="color: red"> <?php echo form_error('specie'); ?></div>
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            <!--./col-md-12 -->
                        </div>
                        <!--./row -->

                        <?php echo form_close(); ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->
        </div>
    </div>
</div>
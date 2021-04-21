<script src="<?php echo base_url() ?>assets/public/ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add Clinical Manifestation</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('ohkr/symptoms') ?>">Clinical Manifestation</a></li>
                <li class="active">Add Clinical Manifestation</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="pure-form">

                        <?php echo form_open('ohkr/add_new_symptom', 'role="form"'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_symptom_name") ?> <span class="red"> * </span></label>
                                    <input type="text" name="name" placeholder="Enter title" class="form-control" value="<?php echo set_value('name'); ?>">
                                </div>
                                <div class="error" style="color: red"> <?php echo form_error('name'); ?></div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("label_symptom_code") ?> <span class="red"> * </span></label>
                                    <input type="text" name="code" placeholder="Enter code" class="form-control" value="<?php echo set_value('code'); ?>">
                                </div>
                                <div class="error" style="color: red"><?php echo form_error('code'); ?></div>

                                <div class="form-group">
                                    <label> <label for="campus"><?php echo $this->lang->line("label_description") ?> :</label> </label>
                                    <textarea class="form-control" name="description" id="description"><?php echo set_value('description'); ?></textarea>
                                    <script>
                                        CKEDITOR.replace('description');
                                    </script>
                                </div>
                                <?php echo form_error('description'); ?>

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
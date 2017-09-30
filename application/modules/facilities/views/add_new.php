<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add new health facility</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= site_url('facilities/lists') ?>">Manage facilities</a></li>
                <li class="active">Add new facilities</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php echo form_open('facilities/add_new', 'role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                            <?php echo form_input($name); ?>
                        </div>

                        <div class="form-group">
                            <label>District</label>
                            <?php
                            $district_options = array();
                            foreach ($district_list as $v) {
                                $district_options[$v->id] = $v->name;
                            }
                            $district_options = array('' => 'Choose district') + $district_options;
                            echo form_dropdown('district', $district_options, set_value('district'), 'class="form-control"');
                            ?>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <?php echo form_textarea($address); ?>
                        </div>

                        <div class="form-group">
                            <label>Latitude</label>
                            <?php echo form_input($latitude); ?>
                        </div>

                        <div class="form-group">
                            <label>Longitude</label>
                            <?php echo form_input($longitude); ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <div class="form-group"></div>
                    <?php echo form_close(); ?>

                </div>
            </div>

        </div>
    </div>
</div>
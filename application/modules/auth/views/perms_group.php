<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Assign permission : <?php echo strtoupper($group_name) ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Assign permission</li>
            </ol>


            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>
            <?php echo form_open('auth/perms_group/' . $group_id);

            foreach ($perm_list[0] as $key => $value) { ?>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b><?php echo $key; ?></b></div>
                        <div class="panel-body" style="height: 250px !important; overflow: scroll;">
                            <?php
                            foreach ($value as $k => $v):
                                $module_id = $perm_list[1][$key][$k]; ?>

                                <div class="form-group">
                                    <label><?php echo $module_id[2]; ?></label>
                                    <input type="checkbox"
                                           name="module_<?php echo $module_id[0] . '_' . $module_id[1] ?>" <?php echo($v == 1 ? 'checked="checked"' : ''); ?>
                                           value="1">

                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <div class="form-group">
                    <input type="submit" value="Assign access" name="save" class="btn btn-primary"/>
                </div>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
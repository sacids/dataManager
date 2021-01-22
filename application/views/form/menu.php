<div id="content-middle-home">
    <div class="container_12" id="content-middle" style="border: 1px solid #fff;">
        <div id="header-title" style="border-top:  1px solid #fff;border-left:  1px solid #fff;">
            <div style="width: auto; float: left; display: inline-block;">
                <img src="<?php echo base_url(); ?>assets/public/images/survey.png"/>
                <h1>Form</h1>
                <h3><?php echo $title; ?></h3>
            </div>
            <?php //$this->load->view('subheader'); ?>
            <div style="clear: both;"></div>
        </div>

        <div>
            <div class="grid_2" id="leftmenu" style=" padding-top: 10px; width: 200px;margin-left: -0.5px;">
                <ul id="nav">
                    <li><a href="<?php echo site_url('xform/forms'); ?>">Form List</a></li>
                    <li><a href="<?php echo site_url('xform/add_new'); ?>">Add New Form</a></li>
                </ul>
            </div>

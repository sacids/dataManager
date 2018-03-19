<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Media Manager</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Media Manager</li>
            </ol>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('newsletters/media/upload', '<i class="fa fa-upload"></i> Upload Media', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($media_list) && $media_list) {
                        $serial = 1;
                        foreach ($media_list as $value) { ?>
                            <div class="col-sm-2">
                                <?php
                                if (file_exists('./assets/uploads/media/' . $value->name))
                                    echo '<img src="' . base_url('assets/uploads/media/' . $value->name) . '" width="180" />';
                                ?>
                            </div>
                            <?php $serial++;
                        } ?>
                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No any matching media.', 'warning');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
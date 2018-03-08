<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Modules List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Modules List</li>
            </ol>


            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('auth/add_module', '<i class="fa fa-plus"></i> Add new module', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($module_list) && $module_list) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th width="20%">Module</th>
                                <th width="20%">Controller</th>
                                <th width="6%"></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($module_list as $value) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $value->name; ?></td>
                                    <td><?= $value->controller; ?></td>
                                    <td><?= anchor("auth/edit_module/" . $value->id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"'); ?></td>
                                </tr>
                                <?php
                                $serial++;
                            } ?>
                        </table>
                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>

                    <?php } else {
                        echo display_message('No any module found', 'warning');
                    } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div><!--./col-sm-12 -->
    </div><!--./row -->
</div><!--./container -->


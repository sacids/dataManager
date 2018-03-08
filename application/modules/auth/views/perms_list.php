<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Permissions List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Permissions List</li>
            </ol>

            <div class="row" style="margin-top: 5px;">
                <div class="col-sm-12">
                    <?php if ($this->ion_auth->is_admin()) { ?>
                        <span class="pull-left" style="padding: 3px;">
                            <?= anchor('auth/add_perm', '<i class="fa fa-plus"></i> Add Permission', 'class="btn btn-sm btn-primary"') ?>
                        </span>
                    <?php } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->

            <div class="row">
                <div class="col-sm-12">
                    <?php if (isset($perms) && $perms) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th>Module</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($perms as $value):?>
                                <tr>
                                    <td><?= $serial; ?></td>
                                    <td><?= $value->m_name; ?></td>
                                    <td><?= $value->p_name; ?></td>
                                    <td><?= $value->perm_slug; ?></td>
                                    <td><?= anchor("auth/edit_perm/" . $value->p_id, '<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"'); ?></td>
                                </tr>
                                <?php
                                $serial++;
                            endforeach; ?>
                        </table>
                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No permission found', 'warning');
                    } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>


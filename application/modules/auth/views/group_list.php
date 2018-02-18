<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Group List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Group List</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">

                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin() || perms_role('auth', 'create_group')) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('auth/create_group', '<i class="fa fa-plus"></i> Create Group', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($group_list) && $group_list) { ?>
                        <table class="table table-striped table-responsive table-bordered table-hover">
                            <tr>
                                <th width="3%"></th>
                                <th width="12%">Group Name</th>
                                <th width="30%">Group Description</th>
                                <th width="12%">Action</th>
                            </tr>
                            <?php
                            $serial = 1;
                            foreach ($group_list as $values) {
                                ?>
                                <tr>
                                    <td><?= $serial; ?></td>
                                    <td><?= ucfirst($values->name); ?></td>
                                    <td><?= $values->description; ?></td>
                                    <td>
                                        <?= anchor("auth/edit_group/" . $values->id, lang('edit_group_heading'), array("class" => 'btn btn-primary btn-xs')); ?>
                                        <?= anchor("auth/perms_group/" . $values->id, 'Assign Permission', array("class" => 'btn btn-warning btn-xs')); ?>
                                    </td>
                                </tr>
                                <?php
                                $serial++;
                            } ?>
                        </table>
                    <?php } else {
                        echo display_message('No group found', 'warning');
                    } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>

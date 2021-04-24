<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Users</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>

            <div class="row">
                <div class="col-lg-12">
                    <?php if ($this->session->flashdata('message') != "")
                        echo $this->session->flashdata('message');
                    ?>

                    <div class="row">
                        <div class="col-lg-9">
                            <div class="pull-left" style="padding: 3px;">
                                <?php
                                if ($this->ion_auth->is_admin() || perms_role('users', 'create'))
                                    echo anchor('auth/users/create', '<i class="fa fa-plus"></i> Register New', 'class="btn btn-sm btn-primary"') . '&nbsp;&nbsp;';
                                ?>
                            </div>

                        </div>
                        <!--./col-md-9 -->
                    </div>
                    <!--./end of row -->


                    <?php if (isset($users) && count($users) > 0) { ?>
                        <table class="table table-bordered" id="my-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="18%">Name</th>
                                    <th width="15%">Email</th>
                                    <th width="10%">Phone</th>
                                    <th width="10%">Username</th>
                                    <th width="13%">Groups</th>
                                    <th width="8%">Status</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $serial = 1;
                                foreach ($users as $values) { ?>
                                    <tr>
                                        <td><?= $serial ?></td>
                                        <td><?= ucfirst($values->first_name) . ' ' . ucfirst($values->last_name); ?></td>
                                        <td><?= $values->email; ?></td>
                                        <td><?= $values->phone; ?></td>
                                        <td><?= $values->username; ?></td>
                                        <td>
                                            <?php
                                            $i = 1;
                                            $grp_array = [];
                                            foreach ($values->groups as $group) {
                                                echo $group->name . ', ';
                                                array_push($grp_array, $group->name);
                                                $i++;
                                            } ?>
                                        </td>
                                        <td>
                                            <?= ($values->active == 1) ?  '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($this->ion_auth->is_admin() || perms_role('users', 'edit')) {
                                                echo anchor('auth/users/edit/' . $values->user_id, '<i class="fa fa-pencil"></i>', array("class" => 'btn btn-primary btn-xs')) . '&nbsp;';

                                                if (count($grp_array) == 1 && $grp_array[0] == 'data_collectors') {
                                                    //do nothing
                                                } else {
                                                    echo anchor("auth/users/mapping/" . $values->user_id, '<i class="fa fa-id-card" aria-hidden="true"></i>', array("class" => 'btn btn-info btn-xs')) . '&nbsp;';
                                                    echo anchor("auth/users/data_access/" . $values->user_id, '<i class="fa fa-key" aria-hidden="true"></i>', array("class" => 'btn btn-warning btn-xs'));
                                                }
                                            }
                                            ?></td>
                                    </tr>
                                <?php
                                    $serial++;
                                } ?>
                            </tbody>
                        </table>
                        <?php if (!empty($links)) : ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>
                    <?php } else {
                        echo display_message('No any user found', 'warning');
                    } ?>
                </div>
                <!--./col-lg-12 -->
            </div>
            <!--./row -->
        </div>
    </div>
</div>
<!-- /.container-fluid -->
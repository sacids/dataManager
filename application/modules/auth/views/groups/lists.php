<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Groups</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Groups</li>
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
                                        <?= anchor('auth/groups/create', '<i class="fa fa-plus"></i> Create New', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($groups) && $groups) { ?>
                        <table class="table table-striped table-responsive table-bordered table-hover">
                            <tr>
                                <th width="3%">#</th>
                                <th width="25%">Group Name</th>
                                <th width="45%">Group Description</th>
                                <th width="6%">Action</th>
                            </tr>
                            <?php
                            $serial = 1;
                            foreach ($groups as $values) {
                                ?>
                                <tr>
                                    <td><?= $serial; ?></td>
                                    <td><?= ucfirst($values->name); ?></td>
                                    <td><?= $values->description; ?></td>
                                    <td>
                                    <?php
                                    //if ($this->ion_auth->is_admin() || perms_role('groups', 'edit'))
                                        echo anchor("auth/groups/edit/" . $values->id, '<i class="fa fa-pencil"></i>', array("class" => 'btn btn-primary btn-xs')) . '&nbsp;&nbsp;&nbsp;&nbsp;';

                                    //if ($this->ion_auth->is_admin() || perms_role('groups', 'assign_perms'))
                                        echo anchor('auth/groups/perms/' . $values->id, '<i class="fa fa-user-secret"></i>', array("class" => 'btn btn-warning btn-xs'));
                                    ?>
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

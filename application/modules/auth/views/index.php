<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Users List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Users List </li>
            </ol>

            <div class="row">
                <div class="col-sm-12">

                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <?php if ($this->ion_auth->is_admin() || perms_role('auth', 'create_user')) { ?>
                                <span class="pull-left" style="padding: 3px;">
                                        <?= anchor('auth/create_user', '<i class="fa fa-plus"></i> Create New User', 'class="btn btn-sm btn-primary"') ?>
                                    </span>
                            <?php } ?>

                            <div class="pull-right">
                                <?= form_open("auth/users_list", 'class="form-inline" role="form"'); ?>

                                <div class="form-group">
                                    <?= form_input(array('name' => 'name', 'id' => 'name', 'class' => "form-control", 'placeholder' => lang('index_name_th'))); ?>
                                </div>

                                <div class="form-group">
                                    <?= form_input(array('name' => 'phone', 'id' => 'phone', 'class' => "form-control", 'placeholder' => lang('index_phone_th'))); ?>
                                </div>

                                <div class="form-group">
                                    <?= form_dropdown("status", array("" => "Choose status", 1 => "Active", 0 => "Inactive"), NULL, 'class="form-control"'); ?>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <?= form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div><!--./col-sm-12 -->
                    </div><!--./row -->

                    <?php if (isset($user_list) && $user_list) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th width="12%">Name</th>
                                <th width="5%">Username</th>
                                <th width="5%"><?= lang('index_phone_th'); ?></th>
                                <th width="10%"><?= lang('index_created_on_th'); ?></th>
                                <th width="8%"><?= lang('index_groups_th'); ?></th>
                                <th width="5%"><?= lang('index_status_th'); ?></th>
                                <th width="15%"></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($user_list as $user):?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $user->first_name . ' ' . $user->last_name; ?></td>
                                    <td><?= $user->username; ?></td>
                                    <td><?= $user->phone; ?></td>
                                    <td><?= date('d-m-Y H:i:s', $user->created_on); ?></td>
                                    <td>
                                        <?php
                                        $i = 1;
                                        $names = array();
                                        foreach ($user->groups as $group) {
                                            echo $i . '. ' . ucfirst(str_replace('_', ' ', $group->name)) . "<br/>";
                                            array_push($names, $group->name);
                                            $i++;
                                        } ?>
                                    </td>
                                    <td><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link'), array("class" => 'btn btn-primary btn-xs')) :
                                            anchor("auth/activate/" . $user->id, lang('index_inactive_link'), array("class" => 'btn btn-danger btn-xs')); ?>
                                    </td>
                                    <td>
                                        <?= anchor("auth/edit_user/" . $user->id, '<i class="fa fa-pencil"></i> Edit', array("class" => 'btn btn-primary btn-xs')) . '&nbsp;&nbsp;'; ?>

                                        <?php
                                        if (in_array('DMO_DVO', $names) || in_array('LFO', $names) || in_array('Mikumi', $names)) {
                                            echo anchor("auth/mapping/" . $user->id, 'Mapping', array("class" => 'btn btn-info btn-xs')) . '&nbsp;&nbsp;';
                                            echo anchor("auth/accesscontrol/assign_permission/" . $user->id, 'Permission', array("class" => 'btn btn-warning btn-xs'));
                                        }

                                        ?>
                                    </td>
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
                        echo display_message('No user found', 'warning');
                    } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div><!--./col-sm-12 -->
    </div><!--./row -->
</div><!--./container -->

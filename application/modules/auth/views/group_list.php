<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Group List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List groups</li>
            </ol>

            <div class="row">
                <div class="col-sm-9">
                    <table class="table table-striped table-responsive table-hover">
                        <tr>
                            <th>S/n</th>
                            <th>Group Name</th>
                            <th>Group Description</th>
                            <th>Action</th>
                            </th>
                        </tr>
                        <?php
                        $serial = 1;
                        foreach ($groups as $values):?>
                            <tr>
                                <td><?php echo $serial; ?></td>
                                <td><?php echo ucfirst($values->name); ?></td>
                                <td><?php echo $values->description; ?></td>
                                <td>
                                    <?php echo anchor("auth/edit_group/" . $values->id, lang('edit_group_heading'), array("class" => 'btn btn-primary btn-xs')); ?>
                                    <?php echo anchor("auth/perms_group/" . $values->id, 'Assign Permission', array("class" => 'btn btn-warning btn-xs')); ?>
                                </td>
                            </tr>
                            <?php
                            $serial++;
                        endforeach; ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

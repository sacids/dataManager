<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $title ?></h3>
            </div>

            <div class="col-sm-6">
                <p><a class="btn btn-primary" href="<?= site_url('auth/add_perm') ?>">Add Perm</a></p>

                <table class="table table-striped table-responsive table-hover">
                    <tr>
                        <th>Module</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>

                    <?php
                    $serial = 1;
                    foreach ($perms as $value):?>
                        <tr>
                            <td><?php echo $value->m_name; ?></td>
                            <td><?php echo $value->p_name; ?></td>
                            <td><?php echo $value->perm_slug; ?></td>
                            <td><?php echo anchor("auth/edit_perm/" . $value->p_id, "Edit", array("class" => 'btn btn-primary btn-xs')); ?></td>
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
            </div>
        </div>
    </div>
</div>


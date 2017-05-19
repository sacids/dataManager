<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?php echo $title ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List module</li>
            </ol>

            <div class="col-sm-6">
                <p><a class="btn btn-primary" href="<?= site_url('auth/add_module') ?>">Add Module</a></p>

                <table class="table table-striped table-responsive table-hover">
                    <tr>
                        <th>Module</th>
                        <th>Controller</th>
                        <th></th>
                    </tr>

                    <?php
                    $serial = 1;
                    foreach ($module as $value):?>
                        <tr>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->controller; ?></td>
                            <td><?php echo anchor("auth/edit_module/" . $value->id, "Edit"); ?></td>
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


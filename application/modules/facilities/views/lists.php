<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Health Facilities List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List health facilities</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <?php if (count($facilities_list) > 0) { ?>
                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <th width="20%">Name</th>
                                <th width="10%">District</th>
                                <th width="20%">Latitude</th>
                                <th width="8%">Longitude</th>
                                <th width="15%">Address</th>
                                <th width="8%"><?php echo $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($facilities_list as $facility) { ?>
                                <tr>
                                    <td><?= $facility->name ?></td>
                                    <td><?= $facility->district->name ?></td>
                                    <td><?= $facility->latitude; ?></td>
                                    <td><?= $facility->longitude; ?></td>
                                    <td><?= $facility->address; ?></td>
                                    <td>
                                        <?= anchor("facilities/edit/" . $facility->id, "Edit"); ?> |
                                        <?= anchor("facilities/delete/" . $facility->id, "Delete", "class='delete'"); ?>
                                    </td>
                                </tr>
                                <?php $serial++;
                            } ?>
                        </table>
                        <?php if (!empty($links)): ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>

                    <?php } else {
                        echo display_message('No health facility yet', 'danger');
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Laboratory Results</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Laboratory Results</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-right">
                        <?php echo anchor("brucella/export_xls/" . $form->id, '<i class="fa fa-file-excel-o fa-lg"></i>&nbsp;&nbsp;', 'title="Export XLS"') ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if ($this->session->flashdata('message') != '') {
                        echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                    } ?>

                    <?php if (isset($data_lists) && $data_lists) { ?>
                        <table class="table table-striped table-responsive table-hover table-bordered">
                            <tr>
                                <th width="3%"></th>
                                <th width="18%">Patient Name</th>
                                <th width="5%">Age</th>
                                <th width="5%">Sex</th>
                                <th width="10%">Barcode</th>
                                <th width="15%">Health Center</th>
                                <th width="10%">Submitted On</th>
                                <th width="8%">Rose Bengal</th>
                                <th width="8%">Sua Results</th>
                                <th width="6%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($data_lists as $val) { ?>
                                <tr>
                                    <td><?= $serial ?></td>
                                    <td><?= $val->_xf_650ad80ca14caa5f0e0dde5742811587 ?></td>
                                    <td><?= $val->_xf_ec0c9332aa8e8195404c7d072b8dc0e8 ?></td>
                                    <td><?= $val->_xf_27e177f79abab493a9294c8f22a2f9da ?></td>
                                    <td><?= $val->_xf_97ec8c6f99c8dfe34679782c060b528d ?></td>
                                    <td><?= $val->_xf_b27aa6e86824bbcecc38414cb75e06ef ?></td>
                                    <td><?= date('d-m-Y', strtotime($val->submitted_at)) ?></td>
                                    <td><?= ($val->rose_bengal) ? strtoupper($val->rose_bengal->_xf_d9e56ce2bd10d1c7faa554d2b1826910) : "NO RESULTS" ?></td>
                                    <td><?= ($val->sua_result) ? strtoupper($val->sua_result->_xf_24c67cb06cc2cb8c50ad41b2c5d8be6f) : "" ?></td>
                                    <td></td>
                                </tr>
                            <?php $serial++;
                            } ?>
                        </table>
                        <?php if (!empty($links)) : ?>
                            <div class="widget-foot">
                                <?= $links ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>

                    <?php } else {
                        echo display_message('No any results found', 'warning');
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Résultats de laboratoire</h3>
            </div>

            <!-- Fil d'Ariane -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Tableau de bord</a></li>
                <li class="active">Résultats de laboratoire</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-right">
                        <?php echo anchor("brucella/export_xls/" . $form->id, '<i class="fa fa-file-excel-o fa-lg"></i>&nbsp;&nbsp;', 'title="Exporter XLS"') ?>
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
                                <th width="18%">Nom du patient</th>
                                <th width="5%">Âge</th>
                                <th width="5%">Sexe</th>
                                <th width="10%">Code-barres</th>
                                <th width="15%">Centre de santé</th>
                                <th width="10%">Soumis le</th>
                                <th width="8%">Rose Bengal</th>
                                <th width="8%">Résultats SUA</th>
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
                                    <td><?= ($val->rose_bengal) ? strtoupper($val->rose_bengal->_xf_d9e56ce2bd10d1c7faa554d2b1826910) : "AUCUN RÉSULTAT" ?></td>
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
                        echo display_message('Aucun résultat trouvé', 'warning');
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>

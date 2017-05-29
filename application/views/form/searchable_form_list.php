<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">List searchable form
                    <span class="pull-right">
                        <?= anchor("xform/add_searchable_form", 'Add searchable form', 'class="btn-link"') ?></span>
                </h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">List searchable form</li>
            </ol>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
            } ?>

            <div class="row">
                <div class="col-sm-6">

                    <?php if (count($form_list) > 0) { ?>
                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <th>Form name</th>
                                <th>Search fields</th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($form_list as $form) { ?>
                                <tr>
                                    <td><?= $form->xform->title; ?></td>
                                    <td><?= $form->search_fields; ?></td>
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

                    <?php } else { ?>
                        <div class="fail_message">Nothing found</div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
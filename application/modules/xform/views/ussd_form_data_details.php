<div class="container body-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $project->title . ' : ' . $title ?> données USSD collectées</h3>
            </div>

            <!-- Fil d'Ariane -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Tableau de bord</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projets</a></li>
                <li><a href="<?= site_url('projects/forms/' . $project->id) ?>"><?= $project->title ?></a></li>
                <li class="active"><?= $title ?></li>
            </ol>

            <div class="row">
                <div class="col-sm-12">

                    <div class="pull-right">
                        <?php echo anchor("api/v3/ussd/export_fao_data", '<i class="fa fa-file-excel-o fa-lg"></i>&nbsp;&nbsp;', 'title="Exporter XLS"') ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo get_flashdata();
                    echo validation_errors();
                    ?>
                </div>
            </div>

            <div style="overflow-x: scroll;">
                <table class="table table_list table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="5%">N°</th>
                        <th width="10%">District</th>
                        <th width="12%">Ward</th>
                        <th width="10%">Animal</th>
                        <th width="12%">Âge</th>
                        <th width="30%">Problème</th>
                        <th width="15%">Date de Soumission</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $serial = 1;
                    foreach ($data_list as $value) {
                        $ward_ng_array = ['1' => 'Kasulo', '2' => 'Kabanga'];
                        $ward_kls_array = ['1' => 'Madoto', '2' => 'Parakuyo'];
                        $ward_wt_array = ['1' => 'Kisiwani', '2' => 'Kinyasini'];

                        // District
                        $district = '';
                        $ward = '';
                        if ($value->district == 1) {
                            $district = "Ngara";
                            $ward = $ward_ng_array[$value->ward_ng];

                        } else if ($value->district == 2) {
                            $district = "Kilosa";
                            $ward = $ward_kls_array[$value->ward_kls];

                        } else if ($value->district == 3) {
                            $district = "Wete";
                            $ward = $ward_wt_array[$value->ward_wt];
                        }

                        // Animal
                        $animal_array = ['1' => 'Ng\'ombe', '2' => 'Mbuzi', '3' => 'Kondoo', '4' => 'Nguruwe', '5' => 'Kuku', '6' => 'Mbwa'];
                        $animal = $animal_array[$value->animal];

                        // Âge
                        $age_array = ['1' => 'Moins d\'un an', '2' => 'Un an et plus'];
                        $age = $age_array[$value->age];

                        // Problèmes
                        $problems = str_split($value->problem);

                        $problems_array = ['1' => 'Diarrhée', '2' => 'Toux', '3' => 'Saignements', '4' => 'Avortement',
                            '5' => 'Difficulté à respirer', '6' => 'Tremblements', '7' => 'Lésions aux pattes et à la bouche', '8' => 'Refus de s\'alimenter', '9' => 'Décédé'
                        ];

                        $push = [];
                        foreach ($problems as $v) {
                            array_push($push, $problems_array[$v]);
                        }

                        $problems_data = implode(",", $push); ?>

                        <tr>
                            <td><?= $serial ?></td>
                            <td><?= $district ?></td>
                            <td><?= $ward ?></td>
                            <td><?= $animal ?></td>
                            <td><?= $age ?></td>
                            <td><?= $problems_data ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($value->submitted_at)) ?></td>
                        </tr>
                        <?php
                        $serial++;
                    } ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($links)): ?>
                <div class="widget-foot">
                    <?= $links ?>
                    <div class="clearfix"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

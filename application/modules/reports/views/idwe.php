<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 27/09/2017
 * Time: 10:16
 */

?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div style="padding: 0 0 0 30px;">
                    <?php
                    echo form_open("", ['method' => "post", "role" => "form", "class" => "form-inline"]);
                    echo "<div class='form-group'>";
                    echo form_dropdown("report", $reports, null, 'class="form-control" style="margin-right:10px;"');
                    echo "</div><div class='form-group'>";
                    echo form_dropdown("group_by", $group_by_options, null, 'class="form-control" style="margin-right:10px;"');
                    echo "</div><div class='form-group'>";
                    echo form_submit("submit", "Submit", 'class="btn btn-primary"');
                    echo "</div>";
                    echo form_close();
                    ?>
                </div>
                <div id='idwe-chart' class="" style="min-height: 600px;"></div>
            </div>
        </div>
    </div>
<?php

$icategories = [];
$afp_count = [];
$anthrax_count = [];
$blood_diarrhea_count = [];
$cholera_count = [];
$meningitis_count = [];
$human_influenza_count = [];
$keratoconjuctivitis_count = [];
$measles_count = [];
$neonatal_tetanus_count = [];
$plague_count = [];
$rabbies_count = [];
$animal_bites_count = [];
$small_pox_count = [];
$dengue_fever_count = [];
$viral_haemorrhagic_count = [];
$yellow_fever_count = [];
$malaria_count = [];

if (isset($report_type) && $report_type == "single_disease") {
    $occurrence_count = [];

    foreach ($report_data as $data) {
        $occurrence_count[] = $data->occurrence_count;

        if ($group_by_column) {
            $icategories[] = $data->$group_by_column;
        } else {
            $icategories[] = $data->_xf_95b360beefc40c13b168164f302de79d;
        }
    }

    log_message("debug", " icategories  => " . json_encode($icategories));
    log_message("debug", " returned json => " . json_encode($occurrence_count, JSON_NUMERIC_CHECK));
    ?>


    <script type="text/javascript">
        $(function () {

            Highcharts.setOptions({
                lang: {
                    thousandsSep: ','
                }
            });

            $('#idwe-chart').highcharts({
                    chart: {
                        type: 'column'
                    },
                    colors: ['#006BA6'],
                    title: {
                        text: '<?=$chart_title?>'
                    },
                    xAxis: {
                        categories: <?=json_encode($icategories)?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '<?=$yaxis_title?>'
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.02,
                            borderWidth: 1
                        }
                    },
                    series: [{
                        name: '<?=$disease_name?>',
                        data: <?=json_encode($occurrence_count, JSON_NUMERIC_CHECK)?>
                    }],
                    credits:
                        {
                            enabled: false
                        }
                }
            )
            ;
        });
    </script>
<?php } else {

    foreach ($report_data as $data) {
        $afp_count[] = $data->afp_count;
        $anthrax_count[] = $data->anthrax_count;
        $blood_diarrhea_count[] = $data->blood_diarhhea_count;
        $cholera_count[] = $data->cholera_count;
        $meningitis_count[] = $data->meningitis_count;
        $human_influenza_count[] = $data->human_influenza_count;
        $keratoconjuctivitis_count[] = $data->keratoconjuctivitis_count;
        $measles_count[] = $data->measles_count;
        $neonatal_tetanus_count[] = $data->neonatal_tetanus_count;
        $plague_count[] = $data->plague_count;
        $rabbies_count[] = $data->rabbies_count;
        $animal_bites_count[] = $data->animal_bites_count;
        $small_pox_count[] = $data->small_pox_count;
        $dengue_fever_count[] = $data->dengue_fever_count;
        $viral_haemorrhagic_count[] = $data->viral_haemorrhagic_count;
        $yellow_fever_count[] = $data->yellow_fever_count;
        $malaria_count[] = $data->malaria_count;

        if ($group_by_column) {
            $icategories[] = $data->$group_by_column;
        } else {
            $icategories[] = $data->_xf_95b360beefc40c13b168164f302de79d;
        }
    }
    ?>

    <script type="text/javascript">
        $(function () {

            Highcharts.setOptions({
                lang: {
                    thousandsSep: ','
                }
            });

            $('#idwe-chart').highcharts({
                    chart: {
                        type: 'column'
                    },
                    colors: ['#FA7921','#E55934','#9BC53D','#FDE74C','#5BC0EB','#0B435B','#106588','#2274A5','#5BC0EB','#B9E5F7','#220901','#621708','#941B0C','#BC3908','#F6AA1C','#3772FF','#F038FF'],
                    title: {
                        text: '<?=$chart_title?>'
                    },
                    xAxis: {
                        categories: <?=json_encode($icategories)?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '<?=$yaxis_title?>'
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.02,
                            borderWidth: 1
                        }
                    },
                    series: [{
                        name: 'AFP',
                        data: [<?=implode(",", $afp_count)?>]

                    }, {
                        name: 'Anthrax',
                        data: [<?=implode(",", $anthrax_count)?>]

                    }, {
                        name: 'Blood Diarrhea',
                        data: [<?=implode(",", $blood_diarrhea_count)?>]

                    }, {
                        name: 'Cholera',
                        data: [<?=implode(",", $cholera_count)?>]

                    }, {
                        name: 'Meningitis',
                        data: [<?=implode(",", $meningitis_count)?>]

                    }, {
                        name: 'Human Influenza',
                        data: [<?=implode(",", $human_influenza_count)?>]

                    }, {
                        name: 'Keratoconjuctivitis',
                        data: [<?=implode(",", $keratoconjuctivitis_count)?>]

                    }, {
                        name: 'Measles',
                        data: [<?=implode(",", $measles_count)?>]
                    }, {
                        name: 'Neonatal Tetanus',
                        data: [<?=implode(",", $neonatal_tetanus_count)?>]
                    }, {
                        name: 'Plague',
                        data: [<?=implode(",", $plague_count)?>]
                    }, {
                        name: 'Rabbies',
                        data: [<?=implode(",", $rabbies_count)?>]
                    }, {
                        name: 'Animal Bites',
                        data: [<?=implode(",", $animal_bites_count)?>]
                    }, {
                        name: 'Small pox',
                        data: [<?=implode(",", $small_pox_count)?>]
                    }, {
                        name: 'Dengue fever',
                        data: [<?=implode(",", $dengue_fever_count)?>]
                    }, {
                        name: 'Viral Haemorrhagic',
                        data: [<?=implode(",", $viral_haemorrhagic_count)?>]
                    }, {
                        name: 'Yellow Fever',
                        data: [<?=implode(",", $yellow_fever_count)?>]
                    }, {
                        name: 'Malaria',
                        data: [<?=implode(",", $malaria_count)?>]
                    }],
                    credits: {
                        enabled: false
                    }
                }
            );
        });
    </script>
<?php } ?>
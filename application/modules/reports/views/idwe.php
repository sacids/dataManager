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
                echo form_dropdown("column", $options, null, 'class="form-control" style="margin-right:10px;"');
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
                colors: ['ORANGE', '#910000', '#8bbc21', '#1aadce', '#E5087E', '#1E93C8', "#3B444D", "#028482", "yellow",
                    "green", "#000000", "#663300", "#0000FF", "#B378D3", "#A55D35", "#3964C3", "pink"],
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
<div class="container body-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 main">
            <div id="header-title">
                <h3 class="title"><?= $project->title . ' : ' . $form_details->title ?> Charts</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projects</a></li>
                <li><a href="<?= site_url('projects/forms/' . $project->id) ?>"><?= $project->title ?></a></li>
                <li class="active"><?= $form_details->title ?> Chart</li>
            </ol>


            <div class="pull-right" style="margin-bottom: 10px;">
                <?php
                echo form_open(uri_string(), 'class="form-inline" role="form"');

                $options = array("" => "Select column to plot");
                foreach ($mapped_fields as $key => $value) {
                    if (is_numeric($key)) {
                        $options[$value] = ucfirst(str_replace("_", " ", $value));
                    } else {
                        $options[$key] = ucfirst(str_replace("_", " ", $value));
                    }
                }
                ?>

                <div class="form-group">
                    <label for="Axis Column"></label>
                    <?php echo form_dropdown("axis", $options, '', 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="Group by"></label>
                    <?php $options[""] = "Select column to Group by";
                    echo form_dropdown("group_by", $options, '', 'class="form-control"'); ?>
                </div>

                <div class="form-group">
                    <label for="Operation"></label>
                    <?php echo form_dropdown("function", array("COUNT" => "Count all", "SUM" => "Find summation"), "COUNT", 'class="form-control"'); ?>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <?php echo form_submit("submit", "Submit", 'class="btn btn-primary"'); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <?php echo validation_errors(); ?>
            </div>

            <?php if (empty($categories)):
                $message = "<p class='text-center'>Select <strong>columns</strong> you want to plot against a group column and function you want to use, to see a chart here</p>";
                echo display_message($message, "info"); ?>
            <?php else: ?>
                <div id="graph-content" style="min-height: 600px"></div>
                <script type="text/javascript">

                    $(document).ready(function () {
                        $(function () {

                            Highcharts.setOptions({
                                lang: {
                                    thousandsSep: ','
                                }
                            });

                            $('#graph-content').highcharts({
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: '<?php echo $series['name']; ?>'
                                    },
                                    xAxis: {
                                        categories: <?php echo $categories; ?>
                                    },
                                    yAxis: {
                                        title: {
                                            text: '<?php echo !empty($chart_title) ? $chart_title : "Count"?>'
                                        }
                                    },
                                    series: [{
                                        name: '<?php echo $series['name']; ?>',
                                        data: <?php echo str_replace('"', "", json_encode($series['data']));?>
                                    }],
                                    credits: {
                                        enabled: false
                                    }
                                }
                            );
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>
<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?> > <?= $form->title ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Overview
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/form_data/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Table
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url("visualization/visualization/chart/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Charts
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("visualization/visualization/map/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Map
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/mapping/" . $project->id . '/' . $form->id)?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Mapping Fields
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/permissions/" . $project->id . '/' . $form->id)?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Permission
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">
            <div class="w-full">
                <div class="relative overflow-x-auto">

                <div class="pure-form">
                        <?= form_open(uri_string(), ''); ?>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php
                                    $options = array("" => "Select column to plot");
                                    foreach ($mapped_fields as $key => $value) {
                                        if (is_numeric($key)) {
                                            $options[$value] = ucfirst(str_replace("_", " ", $value));
                                        } else {
                                            $options[$key] = ucfirst(str_replace("_", " ", $value));
                                        }
                                    }
                                    ?>
                                    <?php echo form_dropdown("axis", $options, '', 'class="form-control"'); ?>
                                </div>
                            </div>
                            <!--./col-md-4 -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php $options[""] = "Select column to Group by";
                                    echo form_dropdown("group_by", $options, '', 'class="form-control"'); ?>
                                </div>
                            </div>
                            <!--./col-md-4 -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_dropdown("function", array("COUNT" => "Count all", "SUM" => "Find summation"), "COUNT", 'class="form-control"'); ?>
                                </div>
                            </div>
                            <!--./col-md-4 -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_submit("submit", "Submit", 'class="btn btn-primary"'); ?>
                                </div>
                            </div>
                            <!--./col-md-4 -->
                        </div>
                        <!--./row -->
                        <?php echo form_close(); ?>
                        <?php echo validation_errors(); ?>
                    </div>
                    <!--./pure-form -->
                </div>
                <!--./col-md-12 -->
            </div>
            <!--./row -->

                    <?php if (empty($categories)) :
                        $message = "<p class='text-center'>Select <strong>columns</strong> you want to plot against a group column and function you want to use, to see a chart here</p>";
                        echo display_message($message, "info"); ?>
                    <?php else : ?>
                        <div id="graph-content" style="min-height: 600px"></div>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $(function() {

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
                                                text: '<?php echo !empty($chart_title) ? $chart_title : "Count" ?>'
                                            }
                                        },
                                        series: [{
                                            name: '<?php echo $series['name']; ?>',
                                            data: <?php echo str_replace('"', "", json_encode($series['data'])); ?>
                                        }],
                                        credits: {
                                            enabled: false
                                        }
                                    });
                                });
                            });
                        </script>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>
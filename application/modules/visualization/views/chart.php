<div class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <a href="<?= site_url('projects/forms/' . $project->id) ?>" class="text-red-900"><?= isset($project) ? $project->title : '' ?></a> > <?= $form->title ?>
        </h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <?php
            foreach ($links as $key => $link) {
                echo $link;
            }
            ?>
        </div>
    </div>
</div>
</header>


<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">
            <div class="relative overflow-x-auto">
                <?= form_open(uri_string(), ''); ?>
                <div class="flex flex-row justify-between mb-3">
                    <div>
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
                        <?php echo form_dropdown("axis", $options, '', 'class="w-60 mr-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500"'); ?>
                    </div>

                    <div>
                        <?php $options[""] = "Select column to Group by";
                        echo form_dropdown("group_by", $options, '', 'class="w-60 mr-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500"'); ?>
                    </div>

                    <div>
                        <?php echo form_dropdown("function", array("COUNT" => "Count all", "SUM" => "Find summation"), "COUNT", 'class="w-40 mr-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-0 focus:ring-blue-500 focus:border-blue-500"'); ?>
                    </div>

                    <div>
                        <?php echo form_submit("submit", "Submit", 'class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded-0 text-sm w-full sm:w-auto px-5 py-2 text-center"'); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <?php echo validation_errors(); ?>




                <?php if (empty($categories)) :
                    $message = "<p class='text-center'>Select <strong>columns</strong> you want to plot against a group column and function you want to use, to see a chart here</p>";
                    echo display_message($message, "info"); ?>
                <?php else : ?>
                    <div class="w-full">
                        <div id="graph-content" style="min-height: 600px"></div>
                    </div>
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
        <!-- /End replace -->
    </div>
</main>
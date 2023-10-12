<div class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Tableau de bord</h1>
    </div>
</div>
</header>

<main class="bg-white h-full relative">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <!-- Statistiques -->
        <div class="flex flex-wrap mb-4">
            <!-- Carte de métrique -->
            <div class="w-full md:w-1/4 xl:w-1/4 pr-2">
                <div class="bg-slate-200 border rounded p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-blue-800 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-medium text-gray-600">Collecteurs de données</h5>
                            <h3 class="font-bold text-2xl"><?= (isset($data_collectors) ? number_format($data_collectors) : '0'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/4 xl:w-1/4 px-2 ">
                <div class="bg-slate-200 border rounded p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-orange-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-medium text-gray-600">Formulaires publiés</h5>
                            <h3 class="font-bold text-2xl"><?= (isset($published_forms) ? number_format($published_forms) : '0') ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/4 xl:w-1/4 px-2">
                <div class="bg-slate-200 border rounded p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-red-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-medium text-gray-600">Données collectées</h5>
                            <h3 class="font-bold text-2xl"><?= number_format($sum_collected_data); ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/4 xl:w-1/4 pl-2">
                <div class="bg-slate-200 border rounded p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-green-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h5 class="font-medium text-gray-600">Nombre de retours</h5>
                            <h3 class="font-bold text-xl">
                                <?= (isset($new_feedback) ? number_format($new_feedback) : '0'); ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row flex-wrap mb-2">
            <div class="w-full md:w-3/4 pr-2">
                <div class="bg-slate-200 border rounded-0">
                    <div class="p-2">
                        <h5 class="font-medium text-gray-600 text-left">
                            Soumissions de formulaires récentes
                        </h5>
                    </div>

                    <div class="p-2">
                        <div id="overall-graph" style="height: 400px;"></div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/4">
                <div class="bg-slate-200 border rounded-0">
                    <div class="p-2">
                        <h5 class="font-medium text-gray-600 text-left">
                            Retours récents
                        </h5>
                    </div>

                    <div class="p-2">
                        <div style="height: 400px;" class="overflow-y-auto">
                            <ul class="max-w-md divide-y divide-gray-200">
                                <?php foreach ($feedback as $value) { ?>
                                    <li class="pb-3 sm:pb-4">
                                        <div class="flex items-center space-x-4">
                                            <?php if ($value->sender == "user") : ?>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="text-green-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php elseif ($value->sender == 'server') : ?>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php endif; ?>

                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-normal text-gray-600 truncate">
                                                    <?= ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?>
                                                </p>

                                                <p class="text-sm text-gray-500 truncate">
                                                    <?= $value->message ?>
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-xs font-normal text-gray-600">
                                                <?= time_ago($value->date_created); ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Fin de remplacement -->
    </div>
</main>

<script type="text/javascript">
    //TODO: Créer une fonction à appeler dans la vue

    // Données générales
    $(function() {
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        $('#overall-graph').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: <?php echo $form_title; ?>
            },
            yAxis: {
                title: {
                    text: 'Nombre de données soumises'
                }
            },
            series: [{
                name: '<?php echo $this->lang->line("label_graph_series_name"); ?>',
                data: <?php echo $overall_data; ?>
            }],
            credits: {
                enabled: false
            }
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });

        //daily monitoring dossage
        $.getJSON('/api/v3/forms/charts', (data) => {
            if (data.error == false) {
                var arr_surveys = []
                var arr_collected_data = []

                for (k = 0; k < data.chart.length; k++) {
                    arr_surveys.push(data.chart[k].survey);
                    arr_collected_data.push(data.chart[k].data);
                }

                $('#overall-graph').highcharts({
                    chart: {
                        type: 'column',
                        backgroundColor: '#FFF'
                    },
                    title: {
                        text: null
                    },
                    xAxis: {
                        categories: arr_surveys,
                        crosshair: true,
                        title: {
                            text: "Forms"
                        }
                    },
                    yAxis: {
                        title: {
                            text: "No. of submitted Data"
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:12px; font-weight:600;"> {point.key}</span><table>',
                        pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            // stacking: 'normal',
                            pointPadding: 0.1,
                            borderWidth: 0,
                            dataLabels: {
                                enabled: false,
                                style: {
                                    fontWeight: 'bold'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Submitted Data',
                        color: '#1565C0',
                        data: arr_collected_data
                    }
                    ],
                    credits: {
                        enabled: false
                    }
                });


            }
        });

        //filtering per districts
        $('#select-period').on('change', function (e) {
            e.preventDefault;

            //variables
            var period = $(this).val();

            console.log("reached here => " + period);

            //aggreaget data
            $.getJSON('/api/v3/forms/charts', { period: period }, (data) => {
                if (data.error == false) {
                    var arr_surveys = []
                    var arr_collected_data = []

                    for (k = 0; k < data.chart.length; k++) {
                        arr_surveys.push(data.chart[k].survey);
                        arr_collected_data.push(data.chart[k].data);
                    }

                    $('#overall-graph').highcharts({
                        chart: {
                            type: 'column',
                            backgroundColor: '#FFF'
                        },
                        title: {
                            text: null
                        },
                        xAxis: {
                            categories: arr_surveys,
                            crosshair: true,
                            title: {
                                text: "Forms"
                            }
                        },
                        yAxis: {
                            title: {
                                text: "No. of submitted Data"
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:12px; font-weight:600;">Day {point.key}</span><table>',
                            pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                // stacking: 'normal',
                                pointPadding: 0.1,
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: false,
                                    style: {
                                        fontWeight: 'bold'
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Submitted Data',
                            color: '#1565C0',
                            data: arr_collected_data
                        }
                        ],
                        credits: {
                            enabled: false
                        }
                    });
                }
            });
        });



    });
</script>
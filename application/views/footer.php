<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url() ?>assets/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?= base_url() ?>assets/public/js/highcharts.js"></script>

<?php if (isset($load_map)): ?>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjO8E4UMo5tGs5U9HQ6zLmVQBa3k7UYIs&callback=initMap">
    </script>
<?php endif; ?>

</body>
</html>

<script type="text/javascript">

    <?php if (isset($icategories)){ ?>
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
                        categories: <?php echo $icategories; ?>
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
    <?php } ?>
    $(document).ready(function () {
        //working fine
        // Ajax calls here.
    });
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url() ?>assets/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?= base_url() ?>assets/public/js/highcharts.js"></script>


<script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
<script type="text/javascript" src="http://127.0.0.1/dataManager/assets/public/leaflet/dist/leaflet.markercluster-src.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/perms.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/db_exp.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/afyadata.js"></script>

</body>
</html>

<script type="text/javascript">

    <?php if (isset($categories)){ ?>
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
    <?php } ?>
    $(document).ready(function () {
        //working fine
        // Ajax calls here.
    });
</script>

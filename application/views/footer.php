<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url() ?>assets/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?= base_url() ?>assets/public/js/highcharts.js"></script>


<div class="footer">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12" style="margin-left: 90px;">

            <form class="navbar-form form-inline" role="form">
                <div class="form-group">
                    <label>Change language</label>
                    <select class=""
                            onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageChanger/switchLang/'+this.value;">
                        <option value="swahili" <?php if ($this->session->userdata('site_lang') == 'swahili') echo 'selected="selected"'; ?>>
                            Swahili
                        </option>
                        <option value="english" <?php if ($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>>
                            English
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>

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

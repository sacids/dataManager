<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--title -->
    <title>Afyadata</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- Wrapper-->
<div class="wrapper">
    <div class="container">
        <div class="row" style="padding-top: 30px; padding-bottom: 10px;">
            <div class="pull-right">
                <button class="btn btn-success btn-sm" onclick="printDiv('barcode');">
                    <i class="fa fa-print"></i> Print/Save
                </button>
            </div>
        </div>
    </div>

    <div id="barcode" class="container" style="background-color: #ffffff; padding: 20px;">
        <div class="row">
            <table style="">
                <?php
                if (isset($health_facilities) && $health_facilities) { ?>
                    <?php
                    foreach ($health_facilities as $value) {
                        $bc = $value->code . '01';

                        for ($i = 0; $i < 30; $i++) {
                            $barcode = '<div style="width: 200px; margin: 10px; float: left; padding: 10px;">
                                        <div style="font-size:16px; text-align: center;">Kituo cha Afya : ' . $value->name . '</div>
                                        <div style="padding: 10px; "><img style="margin-left: auto; margin-right: auto; display: block;" src="' . base_url('assets/public/barcodes/') . "/" . $bc . '.png"></div>
                                        <div style="font-size:17px; text-align: center;">' . $bc . '</div>
                                        </div>';

                            if (($i % 2) == 0)
                                echo '</tr><tr>';

                            echo '<tr>';
                            echo '<td>' . $barcode . '</td>';
                            echo '<td>' . $barcode . '</td>';
                            echo '<td>' . $barcode . '</td>';
                            echo '</tr>';
                            $bc++;
                        }
                    }
                } ?>
            </table>
        </div><!--./row -->
    </div><!--./container/br_report -->
</div><!--./wrapper -->

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
</body>

</html>

<div class="container-fluid body-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 main">
            <div id="header-title">
                <h3 class="title"><?= $project->title . ' : ' . $form->title ?> Map</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('projects/lists') ?>">Projects</a></li>
                <li><a href="<?= site_url('projects/forms/' . $project->id) ?>"><?= $project->title ?></a></li>
                <li class="active"><?= $form->title ?> Map</li>
            </ol>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">

        <div style="width: 100%; min-height: 600px; height: auto" id="map"></div>
        <?php echo $addressPoints; ?>
        <script type="text/javascript">

            var tiles = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
                    maxZoom: 18,
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
                }),
                latlng = L.latLng(<?php echo $latlon; ?>);

            var map = L.map("map", {center: [-6.40177, 34.99269], zoom: 6, layers: [tiles]});

            var markers = L.markerClusterGroup();

            for (var i = 0; i < addressPoints.length; i++) {
                var a = addressPoints[i];
                var title = a[2];
                var marker = L.marker(new L.LatLng(a[0], a[1], {title: title}));
                marker.bindPopup(title);
                markers.addLayer(marker);
            }

            map.addLayer(markers);

        </script>
    </div>
</div>
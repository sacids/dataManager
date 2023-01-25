<div class="container">
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
        <!--./col-md-12 -->
    </div>
    <!--./row -->

    <div class="row">
        <div class="col-md-12">
            <div style="min-height: 800px; height: auto; margin-bottom: 20px;" id="map"></div>
            <?php echo $addressPoints; ?>
            <script type="text/javascript">
                // initialize the map
                const map = L.map('map').setView([-18.6696553, 35.5273354], 6);

                //create tileUrl and attribution
                const tileUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibXVsdGljcyIsImEiOiJjazVvMnprajEwaG4wM2xuczQ2YjVqZzQ5In0.udinWRnw_kgrlqkZSVlNQQ';
                const attribution = '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://www.mapbox.com/">Mapbox</a>';

                //create tile
                const tile = L.tileLayer(tileUrl, {
                    maxZoom: 18,
                    attribution: attribution,
                    id: 'mapbox/streets-v11'
                });

                //add title to map
                tile.addTo(map);

                //create group markers
                var markers = L.markerClusterGroup();

                for (var i = 0; i < addressPoints.length; i++) {
                    var a = addressPoints[i];
                    var title = a[2];

                    var marker = L.marker(new L.LatLng(a[0], a[1], {
                        title: title
                    }));
                    marker.bindPopup(title);

                    //Adding marker to the map
                    marker.addTo(map);
                    markers.addLayer(marker);
                }
                //add markers into map layer
                map.addLayer(markers);
            </script>
        </div>
        <!--./col-md-12 -->
    </div>
    <!--./row -->

</div>
<!--./container -->
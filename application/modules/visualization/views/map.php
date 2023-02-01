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
            <div class="w-full">
                <div class="relative overflow-x-auto">
                    <div style="min-height: 800px; height: auto; margin-bottom: 20px;" id="map"></div>
                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>

<?php echo $addressPoints; ?>
<script type="text/javascript">
    // initialize the map
    const map = L.map('map').setView([-6.40177, 34.99269], 6);

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
<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?> > <?= $form->title ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Overview
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/form_data/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Table
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("visualization/visualization/chart/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Charts
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url("visualization/visualization/map/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Map
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/mapping/" . $project->id . '/' . $form->id)?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Mapping Fields
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/permissions/" . $project->id . '/' . $form->id)?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Permission
                    </a>
                </li>
            </ul>
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
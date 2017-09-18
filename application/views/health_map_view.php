<?php
/**
 * AfyaData
 *
 * An open source data collection and analysis tool.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017. Southern African Center for Infectious disease Surveillance (SACIDS)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * @package        AfyaData
 * @author        AfyaData Dev Team
 * @copyright    Copyright (c) 2017. Southen African Center for Infectious disease Surveillance (SACIDS
 *     http://sacids.org)
 * @license        http://opensource.org/licenses/MIT	MIT License
 * @link        https://afyadata.sacids.org
 * @since        Version 1.0.0
 */

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 21-Aug-17
 * Time: 10:24
 */

?>
<div class="container container-full">
    <div id="map"></div>
</div>

<?php
$options = ["" => "Choose form"];
if (isset($public_forms)) {
    foreach ($public_forms as $form) {
        $options[$form->form_id] = $form->title;
    }
}
?>

<div id="hideShowEventDataArea" class="bg-light-grey"
     style="position :fixed; z-index :100; bottom :0;left :0; width :100%;height:auto; padding: 10px;">
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="#" id="closeDataAreaBtn" title="Close"><i class="fa fa-angle-double-down fa-2x text-primary"></i></a>
            <?/*= form_dropdown("form_name", $options, 'class="form-control pull-right"') */?>
        </div>
        <div class="col-md-12" id="eventsDataArea"></div>
    </div>
</div>

<script type="text/javascript">
    var geoPointsObject = JSON.parse('<?=$geo_data_json?>');

    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: {lat: -6.8288657, lng: 37.670589},//-6.8016854
            fullscreenControl: true,
            fullscreenControlOptions: {
                position: google.maps.ControlPosition.BOTTOM_RIGHT
            },
            mapTypeControl: true,
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.BOTTOM_LEFT
            }
        });

        $.each(geoPointsObject, function (key, data) {
            var latLng = new google.maps.LatLng(data.lat, data.lng);
            // Creating a marker and putting it on the map
            var marker = new google.maps.Marker({
                position: latLng,
                label: data.event
                //title: data.event
            });
            marker.setMap(map);
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    }
</script>
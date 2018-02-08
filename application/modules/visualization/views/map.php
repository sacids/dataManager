<div class="container-fluid">
	<div class="row">

			<div style="width: 100%; height: 500px" id="map"></div>
			<?php echo $addressPoints; ?>
			<script type="text/javascript">
				
					var tiles = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
							maxZoom: 18,
							attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
						}),
						latlng = L.latLng(<?php echo $latlon; ?>);
		
						var map = L.map("map", {center: latlng, zoom: 13, layers: [tiles]});
		
						var markers = L.markerClusterGroup();
		
					for(var i = 0; i < addressPoints.length; i++){
						var a = addressPoints[i];
						var title = a[2];
						var marker	= L.marker(new L.LatLng(a[0], a[1],{title: title}));
						marker.bindPopup(title);
						markers.addLayer(marker);
					}
	
					map.addLayer(markers);

				</script>
	</div>
</div>
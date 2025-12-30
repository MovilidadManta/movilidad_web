<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Add a geocoder</title>
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
	<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet">
	<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>
	<style>
		body {
			margin: 0;
			padding: 0;
		}

		#map {
			position: absolute;
			top: 0;
			bottom: 0;
			width: 100%;
		}
	</style>
</head>

<body>
	<style>
		.coordinates {
			background: rgba(0, 0, 0, 0.5);
			color: #fff;
			position: absolute;
			bottom: 40px;
			left: 10px;
			padding: 5px 10px;
			margin: 0;
			font-size: 11px;
			line-height: 18px;
			border-radius: 3px;
			display: none;
		}
	</style>
	<!-- Load the `mapbox-gl-geocoder` plugin. -->
	<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
	<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

	<div id="map"></div>
	<pre id="coordinates" class="coordinates"></pre>


	<script>
		var longitud = 0;
		var latitud = 0;
		// TO MAKE THE MAP APPEAR YOU MUST
		// ADD YOUR ACCESS TOKEN FROM
		// https://account.mapbox.com
		mapboxgl.accessToken = 'pk.eyJ1IjoiamhvbnkyNyIsImEiOiJjajQ0ZDBrc3kwMHVrMzN1YnAybGMzY2pxIn0.m6oCm21xzIXCVTHN9d7stA';
		const map = new mapboxgl.Map({
			container: 'map',
			style: 'mapbox://styles/mapbox/streets-v11',
			center: [-80.493740, -1.038224], // starting position [lng, lat]
			zoom: 6 // starting zoom
		});

		// Add the control to the map.
		map.addControl(
			new MapboxGeocoder({
				accessToken: mapboxgl.accessToken,
				mapboxgl: mapboxgl,
				marker: true // Do not use the default marker style
			})
		);

		function onDragEnd() {
			const lngLat = marker.getLngLat();
			coordinates.style.display = 'block';
			coordinates.innerHTML = `Longitude: ${lngLat.lng}<br />Latitude: ${lngLat.lat}`;
			latitud = lngLat.lat;
		}

		marker.on('dragend', onDragEnd);
	</script>

</body>

</html>
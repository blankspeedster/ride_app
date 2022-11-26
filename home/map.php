<html>
<head>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
<div id='map' style='width: 400px; height: 300px;'></div>
<script>
mapboxgl.accessToken = 'pk.eyJ1Ijoicm9uaWVzcGVlZHN0ZXIwMyIsImEiOiJjbGF4Ymh6dTQwbnpuM3VqdWZwMmoyaXNxIn0.u0-QP8LkNZK11mcjVnOH5w';
const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/streets-v12', // style URL
    center: [-74.5, 40], // starting position [lng, lat]
    zoom: 9, // starting zoom
});
</script>
</body>

</html>
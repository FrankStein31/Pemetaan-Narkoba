@extends('layouts.main.index')
@section('container')
<div class="row">
    <div class="col-md-12 col-lg-12 order-0 mb-4">
      <div class="card h-1000">
        <div class="card-body">

            <div id="map"></div>
            <!-- Make sure you put this AFTER Leaflet's CSS -->
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        </div>
      </div>
    </div>
    <script>
        var map = L.map('map').setView([-7.8015312,111.9448052], 11);

        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 22,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // console.log(@json($desas))
        const desas = @json($desas)
        // const villages= {!! json_encode($desas)!!};

        const desaData = desas
        .filter(desa => desa.polygon && desa.polygon !== 'null')
        .map(desa => ({
            type: "Feature",
            properties:{
                name: desa.nama_desa,
                id: desa.id,
                sosialisasi: desa.sosialisasi,
            },
            geometry: {
                type: desa.type_polygon,
                coordinates: JSON.parse(desa.polygon),
            }
        }));

        const geoJson = {
            type: "FeatureCollection",
            features: desaData,
        };

        function getColor(d) {
            return d >= 1   ? '#0000FF' :
                            '#FF0000';
        }

        function style(feature) {
            return {
                fillColor: getColor(feature.properties.sosialisasi),
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        function highlightFeature(e) {
            var layer = e.target;

            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });

            layer.bringToFront();
            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

        geojson = L.geoJson(geoJson, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);

        var info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };

        // method that we will use to update the control based on feature properties passed
        info.update = function (props) {
            this._div.innerHTML = '<h4>Soialisasi Desa </h4>' +  (props ?
                '<b>' + props.name + '</b><br />' + props.sosialisasi + ' Sosialisasi'
                : 'Arahkan kursor ke suatu Desa');
        };

        info.addTo(map);

        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, 1],
                labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
        var from = grades[i];
        var to = grades[i + 1];

        div.innerHTML +=
            '<i style="background:' + getColor(from) + '"></i> ' +
            (to ? from + '&ndash;' + (to - 1) + '<br>' : from + '+');
    }

            return div;
        };

        legend.addTo(map);

    </script>
@endsection
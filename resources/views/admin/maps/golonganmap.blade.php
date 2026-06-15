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

        const desas = @json($desas);

        const desaData = desas
        .filter(desa => desa.polygon && desa.polygon !== 'null')
        .map(desa => ({
            type: "Feature",
            properties:{
                name: desa.nama_desa,
                id: desa.id,
                golongan_positif: desa.golongan_positif,
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

        function getColor(golongan) {
            if (!golongan || golongan === '' || golongan === null) {
                return '#0B6623'; // Hijau untuk NULL
            }

            const gol = golongan.replace(/\s/g, '').split(',');

            const hasI = gol.includes('GolonganI');
            const hasII = gol.includes('GolonganII');
            const hasIII = gol.includes('GolonganIII');

            if (hasI && hasII && hasIII) {
                return '#000000'; // Hitam
            }
            if (hasI && hasII) {
                return '#0000FF'; // Biru
            }
            if (hasII && hasIII) {
                return '#FFA500'; // Jingga
            }
            if (hasI && hasIII) {
                return '#8B4513'; // Coklat
            }
            if (hasI) {
                return '#FF0000'; // Merah
            }
            if (hasII) {
                return '#FFFF00'; // Kuning
            }
            if (hasIII) {
                return '#808080'; // Abu-abu
            }
            return '#0B6623'; // Default hijau
        }

        function style(feature) {
            return {
                fillColor: getColor(feature.properties.golongan_positif),
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

        info.update = function (props) {
            this._div.innerHTML = '<h4>Golongan Narkoba per Desa</h4>' +  (props ?
                '<b>' + props.name + '</b><br />' +
                (props.golongan_positif ? props.golongan_positif : 'Tidak Ada Data')
                : 'Arahkan kursor ke suatu Desa');
        };

        info.addTo(map);

        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'info legend');
            div.innerHTML +=
                '<i style="background:#FF0000"></i> Golongan I<br>' +
                '<i style="background:#FFFF00"></i> Golongan II<br>' +
                '<i style="background:#808080"></i> Golongan III<br>' +
                '<i style="background:#0000FF"></i> Golongan I & II<br>' +
                '<i style="background:#FFA500"></i> Golongan II & III<br>' +
                '<i style="background:#8B4513"></i> Golongan I & III<br>' +
                '<i style="background:#FFC0CB"></i> Golongan I, II & III<br>' +
                '<i style="background:#0B6623"></i> Tidak Ada Data<br>';
            return div;
        };

        legend.addTo(map);

    </script>

@endsection
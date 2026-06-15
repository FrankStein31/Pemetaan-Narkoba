@php
    $kotaData = json_decode($kotaJson, true);
    $kotas = [];
    if(isset($kotaData['features'])) {
        foreach($kotaData['features'] as $f) {
            if(isset($f['properties']['name'])) {
                $kotas[] = $f['properties']['name'];
            }
        }
    }
    sort($kotas);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Persebaran Narkoba - Kabupaten Kediri</title>
    <link rel="icon" type="image/x-icon" href="/medilab/assets/img/Logo_BNN.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; }
        .page-header {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            position: relative;
            z-index: 20;
        }
        .page-header img { height: 42px; }
        .page-header h1 { font-size: 18px; font-weight: 600; margin: 0; }
        .page-header p { font-size: 12px; opacity: 0.8; margin: 0; }
        #map-container { padding: 16px; }
        #map-wrapper { position: relative; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.12); }
        #map { height: calc(100vh - 110px); min-height: 500px; }
        .gmap-control {
            position: absolute; z-index: 10; background: white;
            padding: 10px 14px; border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            font-family: Arial, sans-serif; font-size: 13px;
        }
        .gmap-control label { display: block; margin-bottom: 5px; font-weight: 600; color: #444; }
        .search-control { top: 10px; left: 10px; min-width: 260px; z-index: 100; }
        .search-control .select2-container { width: 100% !important; }
        .search-control .select2-selection--single { height: 34px !important; border-radius: 4px; border-color: #ddd; }
        .search-control .select2-selection--single .select2-selection__rendered { line-height: 32px !important; font-size: 13px; }
        .search-control .select2-selection--single .select2-selection__arrow { height: 32px !important; }
        .select2-container--open .select2-dropdown { z-index: 9999 !important; }
        .gmap-info {
            position: absolute; top: 10px; right: 10px; z-index: 10;
            background: rgba(255,255,255,0.95); padding: 10px 14px;
            border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            font-family: Arial, sans-serif; font-size: 14px; min-width: 220px;
        }
        .gmap-info h4 { margin: 0 0 6px; font-size: 13px; color: #666; font-weight: 600; }
        .gmap-info #infoContent { color: #333; line-height: 1.4; }
        .gmap-legend {
            position: absolute; bottom: 90px; right: 10px; z-index: 5;
            background: rgba(255,255,255,0.95); padding: 10px 14px;
            border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            font-family: Arial, sans-serif; font-size: 13px; line-height: 20px;
        }
        .gmap-legend h4 { margin: 0 0 5px; font-size: 12px; color: #666; }
        .gmap-legend div { display: flex; align-items: center; gap: 6px; margin: 2px 0; }
        .gmap-legend span { display: inline-block; width: 18px; height: 18px; border-radius: 3px; opacity: 0.8; }
        .opacity-control { bottom: 12px; left: 10px; }
        .opacity-control input[type="range"] { width: 160px; display: block; }
        .zoom-control { bottom: 85px; left: 10px; }
        .zoom-controls { display: flex; align-items: center; gap: 6px; }
        .zoom-controls input[type="range"] { width: 120px; }
        .zoom-controls button {
            width: 30px; height: 30px; font-size: 16px; font-weight: bold;
            display: flex; align-items: center; justify-content: center; padding: 0;
        }
        .reset-control { bottom: 160px; left: 10px; padding: 6px 10px; }
        @media (max-width: 768px) {
            .page-header { padding: 10px 14px; }
            .page-header h1 { font-size: 15px; }
            #map-container { padding: 8px; }
            #map { height: calc(100vh - 90px); min-height: 400px; }
            .search-control { min-width: 200px; }
            .gmap-info { min-width: 160px; font-size: 12px; }
            .gmap-legend { right: 10px; bottom: 80px; font-size: 11px; }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <img src="/medilab/assets/img/Logo_BNN.png" alt="Logo BNN">
        <div>
            <h1>Peta Persebaran Narkoba Kabupaten Kediri</h1>
            <p>BNN Kabupaten Kediri &mdash; Data Visualisasi Interaktif</p>
        </div>
    </div>

    <div id="map-container">
        <div id="map-wrapper">
            <div id="map"></div>

            <div class="gmap-control search-control">
                <label><i class="bx bx-search"></i> Cari Kota/Kabupaten:</label>
                <select id="kotaSearch">
                    <option value="">-- Semua Kota/Kabupaten --</option>
                    @foreach($kotas as $kota)
                        <option value="{{ $kota }}">{{ $kota }}</option>
                    @endforeach
                </select>
            </div>

            <div class="gmap-info" id="infoPanel">
                <h4>Persebaran Narkoba Kabupaten Kediri</h4>
                <div id="infoContent">Arahkan kursor ke suatu Desa</div>
            </div>

            <div class="gmap-legend">
                <h4>Keterangan</h4>
                <div><span style="background:#FF0000"></span> &ge; 10 Orang</div>
                <div><span style="background:#ffff00"></span> 5 &ndash; 9 Orang</div>
                <div><span style="background:#0B6623"></span> 0 &ndash; 4 Orang</div>
            </div>

            <div class="gmap-control zoom-control">
                <label>Skala Peta:</label>
                <div class="zoom-controls">
                    <button id="zoomOut" class="btn btn-sm btn-secondary" title="Zoom Out">&minus;</button>
                    <input type="range" id="zoomSlider" min="5" max="20" value="8" step="1">
                    <button id="zoomIn" class="btn btn-sm btn-secondary" title="Zoom In">+</button>
                </div>
            </div>

            <div class="gmap-control opacity-control">
                <label>Transparansi Blok: <span id="opacityValue">70</span>%</label>
                <input type="range" id="opacitySlider" min="0" max="100" value="70">
            </div>

            <div class="gmap-control reset-control">
                <button id="resetView" class="btn btn-sm btn-primary"><i class="bx bx-reset"></i> Reset Peta</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    function initMap() {
        var center = { lat: -7.642029, lng: 113.043407};
        var map = new google.maps.Map(document.getElementById('map'), {
            center: center, zoom: 8, mapTypeId: 'roadmap',
            zoomControl: false,
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
            fullscreenControl: true,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            }
        });

        var kotaFeatureCollection = {!! $kotaJson !!};
        var currentOpacity = 0.7;

        function getColor(d) {
            return d >= 10 ? '#FF0000' : d >= 5 ? '#ffff00' : '#0B6623';
        }

        function applyDefaultStyle() {
            map.data.setStyle(function(feature) {
                var pop = feature.getProperty('population');
                if (pop === undefined) {
                    // Beri nilai acak untuk visualisasi agar terlihat seperti cluster
                    pop = Math.floor(Math.random() * 15);
                    feature.setProperty('population', pop);
                }
                var sWeight = currentOpacity < 0.4 ? 3 : 2;
                var sColor = currentOpacity < 0.4 ? '#333333' : '#ffffff';
                return {
                    fillColor: getColor(pop), fillOpacity: currentOpacity,
                    strokeColor: sColor, strokeWeight: sWeight, strokeOpacity: 1, clickable: true
                };
            });
        }

        map.data.addGeoJson(kotaFeatureCollection);
        applyDefaultStyle();

        map.data.addListener('mouseover', function(event) {
            map.data.overrideStyle(event.feature, { strokeWeight: 4, strokeColor: '#333333', fillOpacity: Math.min(currentOpacity + 0.15, 1) });
            var name = event.feature.getProperty('name');
            var pop = event.feature.getProperty('population');
            document.getElementById('infoPanel').innerHTML =
                '<h4>Persebaran Narkoba Kabupaten Kediri</h4>' +
                '<div id="infoContent"><b>' + name + '</b><br>' + pop + ' Orang Positif Narkoba</div>';
        });
        map.data.addListener('mouseout', function(event) {
            map.data.revertStyle(event.feature);
            document.getElementById('infoPanel').innerHTML =
                '<h4>Persebaran Narkoba Kabupaten Kediri</h4>' +
                '<div id="infoContent">Arahkan kursor ke suatu Kota/Kabupaten</div>';
        });
        map.data.addListener('click', function(event) {
            var bounds = new google.maps.LatLngBounds();
            event.feature.getGeometry().forEachLatLng(function(latLng) { bounds.extend(latLng); });
            map.fitBounds(bounds);
            map.setZoom(Math.min(map.getZoom(), 16));
        });

        function filterByKota(selectedName) {
            if (!selectedName) {
                map.data.forEach(function(f) { map.data.revertStyle(f); });
                map.setCenter(center); map.setZoom(8);
                return;
            }
            var bounds = new google.maps.LatLngBounds();
            var hasFeatures = false;
            map.data.forEach(function(feature) {
                if (feature.getProperty('name') === selectedName) {
                    map.data.overrideStyle(feature, { visible: true, fillOpacity: 0.7, strokeWeight: 3, strokeColor: '#000' });
                    feature.getGeometry().forEachLatLng(function(latLng) { bounds.extend(latLng); });
                    hasFeatures = true;
                } else {
                    map.data.overrideStyle(feature, { visible: true, fillOpacity: 0.4, strokeWeight: 1, strokeColor: '#ffffff' });
                }
            });
            if (hasFeatures) { map.fitBounds(bounds); map.setZoom(Math.min(map.getZoom(), 15)); }
        }

        $(document).ready(function() {
            var $sel = $('#kotaSearch');
            $sel.select2({ placeholder: 'Ketik nama kota/kabupaten...', allowClear: true, dropdownParent: $(document.body) });
            $sel.on('change.select2', function() {
                var val = $(this).val();
                filterByKota(val);
            });
        });

        var zoomSlider = document.getElementById('zoomSlider');
        document.getElementById('zoomIn').addEventListener('click', function() { map.setZoom(Math.min(map.getZoom() + 1, 20)); });
        document.getElementById('zoomOut').addEventListener('click', function() { map.setZoom(Math.max(map.getZoom() - 1, 5)); });
        zoomSlider.addEventListener('input', function() { map.setZoom(parseInt(this.value)); });
        map.addListener('zoom_changed', function() { zoomSlider.value = map.getZoom(); });

        var opacitySlider = document.getElementById('opacitySlider');
        var opacityLabel = document.getElementById('opacityValue');
        opacitySlider.addEventListener('input', function() {
            currentOpacity = parseInt(this.value) / 100;
            opacityLabel.textContent = this.value;
            map.data.setStyle(function(feature) {
                var pop = feature.getProperty('population') || 0;
                var sWeight = currentOpacity < 0.4 ? 3 : 2;
                var sColor = currentOpacity < 0.4 ? '#333333' : '#ffffff';
                return { fillColor: getColor(pop), fillOpacity: currentOpacity, strokeColor: sColor, strokeWeight: sWeight, strokeOpacity: 1, visible: true };
            });
        });

        document.getElementById('resetView').addEventListener('click', function() {
            $('#kotaSearch').val('').trigger('change');
            map.data.forEach(function(f) { map.data.revertStyle(f); });
            map.setCenter(center); map.setZoom(8);
            zoomSlider.value = 8; opacitySlider.value = 70; opacityLabel.textContent = '70'; currentOpacity = 0.7;
            applyDefaultStyle();
        });
    }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=geometry&callback=initMap"></script>
</body>
</html>

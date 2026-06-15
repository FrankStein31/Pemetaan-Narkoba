@extends('layouts.main.index')
@section('container')
<div class="row">
    <div class="col-md-12 col-lg-12 order-0 mb-4">
        <div class="card h-1000">
            <div class="card-body">
                <div id="map-wrapper">
                    <div id="map"></div>

                    <div class="gmap-control search-control">
                        <label><i class="bx bx-search"></i> Cari Kecamatan:</label>
                        <select id="kecamatanSearch">
                            <option value="">-- Semua Kecamatan --</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="gmap-info" id="infoPanel">
                        <h4>Sosialisasi Desa</h4>
                        <div id="infoContent">Arahkan kursor ke suatu Desa</div>
                    </div>

                    <div class="gmap-legend">
                        <h4>Keterangan</h4>
                        <div><span style="background:#0000FF"></span> Sudah Sosialisasi</div>
                        <div><span style="background:#FF0000"></span> Belum Sosialisasi</div>
                    </div>

                    <div class="gmap-control zoom-control">
                        <label>Skala Peta:</label>
                        <div class="zoom-controls">
                            <button id="zoomOut" class="btn btn-sm btn-secondary" title="Zoom Out">&minus;</button>
                            <input type="range" id="zoomSlider" min="5" max="20" value="11" step="1">
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
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function initMap() {
    var center = { lat: -7.8015312, lng: 111.9448052 };
    var map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 11,
        mapTypeId: 'roadmap',
        zoomControl: false,
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        fullscreenControl: true,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_CENTER
        }
    });

    var desas = @json($desas);
    var currentOpacity = 0.7;

    function getColor(d) {
        return d >= 1 ? '#0000FF' : '#FF0000';
    }

    function applyDefaultStyle() {
        map.data.setStyle(function(feature) {
            var sos = feature.getProperty('sosialisasi') || 0;
            return {
                fillColor: getColor(sos),
                fillOpacity: currentOpacity,
                strokeColor: '#ffffff',
                strokeWeight: 2,
                strokeOpacity: 1,
                clickable: true
            };
        });
    }

    var geoJsonFeatures = desas
        .filter(function(d) { return d.polygon && d.polygon !== 'null'; })
        .map(function(d) {
            return {
                type: 'Feature',
                properties: {
                    name: d.nama_desa,
                    id: d.id,
                    sosialisasi: d.sosialisasi || 0,
                    kecamatan_id: d.kecamatan_id
                },
                geometry: {
                    type: d.type_polygon || 'Polygon',
                    coordinates: JSON.parse(d.polygon)
                }
            };
        });

    map.data.addGeoJson({ type: 'FeatureCollection', features: geoJsonFeatures });
    applyDefaultStyle();

    map.data.addListener('mouseover', function(event) {
        map.data.overrideStyle(event.feature, { strokeWeight: 4, strokeColor: '#333333', fillOpacity: Math.min(currentOpacity + 0.15, 1) });
        var name = event.feature.getProperty('name');
        var sos = event.feature.getProperty('sosialisasi');
        document.getElementById('infoPanel').innerHTML =
            '<h4>Sosialisasi Desa</h4><div id="infoContent"><b>' + name + '</b><br>' + sos + ' Sosialisasi</div>';
    });
    map.data.addListener('mouseout', function(event) {
        map.data.revertStyle(event.feature);
        document.getElementById('infoPanel').innerHTML =
            '<h4>Sosialisasi Desa</h4><div id="infoContent">Arahkan kursor ke suatu Desa</div>';
    });
    map.data.addListener('click', function(event) {
        var bounds = new google.maps.LatLngBounds();
        event.feature.getGeometry().forEachLatLng(function(latLng) { bounds.extend(latLng); });
        map.fitBounds(bounds);
        map.setZoom(Math.min(map.getZoom(), 16));
    });

    function filterByKecamatan(selectedId) {
        if (!selectedId) {
            map.data.forEach(function(f) { map.data.overrideStyle(f, { visible: true }); });
            applyDefaultStyle();
            map.setCenter(center); map.setZoom(11);
            return;
        }
        var bounds = new google.maps.LatLngBounds();
        var hasFeatures = false;
        map.data.forEach(function(feature) {
            if (feature.getProperty('kecamatan_id') === selectedId) {
                map.data.overrideStyle(feature, { visible: true, strokeWeight: 3, strokeColor: '#000' });
                feature.getGeometry().forEachLatLng(function(latLng) { bounds.extend(latLng); });
                hasFeatures = true;
            } else {
                map.data.overrideStyle(feature, { visible: false });
            }
        });
        if (hasFeatures) { map.fitBounds(bounds); map.setZoom(Math.min(map.getZoom(), 15)); }
    }

    $(document).ready(function() {
        var $sel = $('#kecamatanSearch');
        $sel.select2({
            placeholder: 'Ketik nama kecamatan...',
            allowClear: true,
            dropdownParent: $(document.body)
        });
        $sel.on('change.select2', function() {
            var val = $(this).val();
            filterByKecamatan(val ? parseInt(val) : null);
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
            var sos = feature.getProperty('sosialisasi') || 0;
            return { fillColor: getColor(sos), fillOpacity: currentOpacity, strokeColor: '#ffffff', strokeWeight: 2, strokeOpacity: 1, visible: true };
        });
    });

    document.getElementById('resetView').addEventListener('click', function() {
        $('#kecamatanSearch').val('').trigger('change');
        map.data.forEach(function(f) { map.data.overrideStyle(f, { visible: true }); });
        applyDefaultStyle();
        map.setCenter(center); map.setZoom(11);
        zoomSlider.value = 11; opacitySlider.value = 70; opacityLabel.textContent = '70'; currentOpacity = 0.7;
    });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $gmapsKey }}&libraries=geometry&callback=initMap"></script>
@endsection

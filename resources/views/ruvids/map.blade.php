@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <form action="">
            <div class="form-group">
                <select class="form-control select2"></select>
            </div>
        </form>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body" id="mapid"></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Info</h4>
                <hr>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td id="address"></td>
                        </tr>
                        <tr>
                            <td>Link Rute</td>
                            <td>:</td>
                            <td id="route"></td>
                        </tr>
                        <tr>
                            <td>Pengurus</td>
                            <td>:</td>
                            <td id="pengurus"></td>
                        </tr>
                        <tr>
                            <td>Imam</td>
                            <td>:</td>
                            <td id="imam"></td>
                        </tr>
                        <tr>
                            <td>Khatib</td>
                            <td>:</td>
                            <td id="khatib"></td>
                        </tr>
                        <tr>
                            <td>Remas</td>
                            <td>:</td>
                            <td id="remas"></td>
                        </tr>
                        <tr>
                            <td>Muazin</td>
                            <td>:</td>
                            <td id="muazin"></td>
                        </tr>
                        <tr>
                            <td>Luas Tanah</td>
                            <td>:</td>
                            <td id="luasTanah"></td>
                        </tr>
                        <tr>
                            <td>Luas Bangunan</td>
                            <td>:</td>
                            <td id="luasBangunan"></td>
                        </tr>
                        <tr>
                            <td>Daya Tampung</td>
                            <td>:</td>
                            <td id="dayaTampung"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #mapid { min-height: 500px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('.select2').select2({
        placeholder: "Cari nama masjid",
        ajax: {
            url: `{{ route('api.ruvids.search') }}`,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            latitude: item.latitude,
                            longitude: item.longitude,
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    var map = L.map('mapid').setView([{{ config('leaflet.map_center_latitude') }}, {{ config('leaflet.map_center_longitude') }}], {{ config('leaflet.zoom_level') }});
    var baseUrl = "{{ url('/') }}";

    $('.select2').on('select2:select', function(e) {
        var data = e.params.data;
        
        map.flyTo({
            center: [
                parseFloat(data.latitude),
                parseFloat(data.longitude)
            ],
            essential: true // this animation is considered essential with respect to prefers-reduced-motion
        });
    })

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    axios.get('{{ route('api.ruvids.index') }}')
    .then(function (response) {
        L.geoJSON(response.data, {
            pointToLayer: function(geoJsonPoint, latlng) {
                return L.marker(latlng);
            }
        })
        .bindPopup(function (layer) {
            data = layer.feature.properties
            
            $('#name').text(data.name)
            $('#address').text(data.address)
            $('#route').html(`<a href="http://maps.google.com/maps?q=${data.latitude},${data.longitude}" target="_blank" class="btn btn-sm btn-info">Cek rute</a>`)
            $('#pengurus').text(data.pengurus)
            $('#imam').text(data.imam)
            $('#khatib').text(data.khatib)
            $('#remas').text(data.remas)
            $('#muazin').text(data.muazin)
            $('#luasTanah').text(data.luasTanah)
            $('#luasBangunan').text(data.luasBangunan)
            $('#dayaTampung').text(data.dayaTampung)
            
        }).addTo(map)
    })
    .catch(function (error) {
        console.log(error);
    });

    // @can('create', new App\Models\Ruvid)
    // var theMarker;

    // map.on('click', function(e) {
    //     let latitude = e.latlng.lat.toString().substring(0, 15);
    //     let longitude = e.latlng.lng.toString().substring(0, 15);

    //     if (theMarker != undefined) {
    //         map.removeLayer(theMarker);
    //     };

    //     var popupContent = "Your location : " + latitude + ", " + longitude + ".";
    //     popupContent += '<br><a href="{{ route('ruvids.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Add new outlet here</a>';

    //     theMarker = L.marker([latitude, longitude]).addTo(map);
    //     theMarker.bindPopup(popupContent)
    //     .openPopup();
    // });
    // @endcan
</script>
@endpush

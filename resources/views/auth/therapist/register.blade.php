@extends('layouts.therapist')


@section('title',' | Therapist | Login')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.3.1/dist/multiple-select.min.css">

@endsection


@section('content')

    <div id="hero_register">
        <div class="container margin_120_95">
            <div class="row">
                <div class="col-lg-12">
                    <h1>It's time to find you!</h1>
                    <p class="lead">Te pri adhuc simul. No eros errem mea. Diam mandamus has ad. Invenire senserit ad has, has ei quis iudico, ad mei nonumes periculis.</p>
                    <div class="box_feat_2">
                        <i class="pe-7s-map-2"></i>
                        <h3>Let patients to Find you!</h3>
                        <p>Ut nam graece accumsan cotidieque. Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet.</p>
                    </div>
                    <div class="box_feat_2">
                        <i class="pe-7s-date"></i>
                        <h3>Easly manage Bookings</h3>
                        <p>Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet. Eum no atqui putant democritum, velit nusquam sententiae vis no.</p>
                    </div>
                    <div class="box_feat_2">
                        <i class="pe-7s-phone"></i>
                        <h3>Instantly via Mobile</h3>
                        <p>Eos eu epicuri eleifend suavitate, te primis placerat suavitate his. Nam ut dico intellegat reprehendunt, everti audiam diceret in pri, id has clita consequat suscipiantur.</p>
                    </div>
                </div>
                <!-- /col -->
                <div class="col-lg-12 ml-auto">
                    <div class="box_form">
                        <form onsubmit="return formValidate()" action="/therapist/register" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <input type="text"  class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact"  placeholder="Contact Number">
                                    </div>
                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div style="display: none;" class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Problems Can Address</h6>
                                        </div>
                                        <div class="col-md-12">
                                            <select  name="problems[]" id="select" multiple="multiple">
                                                @foreach($problems as $p)
                                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Groups Can Address</h6>
                                        </div>
                                        <div class="col-md-12">
                                            <select   name="groups[]" id="selectGroup" multiple="multiple">
                                                @foreach($groups as $p)
                                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .ms-choice{
                                        height: calc(2.25rem + 2px);
                                        padding: .375rem .75rem;
                                        font-size: 1rem;
                                        line-height: 1.5;
                                        color: #495057;
                                        background-color: #fff;
                                        background-clip: padding-box;
                                        border: 1px solid #ced4da;
                                        border-radius: .25rem;
                                    }

                                    .ms-choice span{
                                        position: relative;
                                    }
                                </style>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 >Address</h6>
                                    <input type="text" id="address-input" name="address_address" class="form-control map-input">
                                    <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                    <input type="hidden" name="address_longitude" id="address-longitude" value="0" />

                                </div>
                                </div>
                            <br>
                            <div id="address-map-container" style="width:100%;height:400px; ">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <!-- /row -->
                            <p class="text-center add_top_30"><input type="submit" class="btn_1" value="Submit"></p>
                            <div class="text-center"><small>Ut nam graece accumsan cotidieque. Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet.</small></div>
                            @include('includes.errors')
                        </form>
                        <style>
                            .invalid-feedback{
                                display: block;
                            }
                        </style>
                    </div>
                    <!-- /box_form -->
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

@endsection

@section('scripts')
    <script src="/js/notify.min.js"></script>
    <script src="https://unpkg.com/multiple-select@1.3.1/dist/multiple-select.min.js"></script>
    <script>
        $(function () {
            $('#select').multipleSelect({
                width:'100%'
            })
            $('#selectGroup').multipleSelect({
                width:'100%'
            })
        })
    </script>
    <script>
        function initialize() {

            $('form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            const locationInputs = document.getElementsByClassName("map-input");

            const autocompletes = [];
            const geocoder = new google.maps.Geocoder;
            for (let i = 0; i < locationInputs.length; i++) {

                const input = locationInputs[i];
                const fieldKey = input.id.replace("-input", "");
                const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

                const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
                const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

                const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                    center: {lat: latitude, lng: longitude},
                    zoom: 13
                });
                const marker = new google.maps.Marker({
                    map: map,
                    position: {lat: latitude, lng: longitude},
                });
                map.addListener('click', function(e) {
                    console.log(e);
                    marker.setPosition(e.latLng);
                    setLocationCoordinates('address',e.latLng.lat(),e.latLng.lng())
                    if(e.placeId==undefined)
                        $('#address-input').val(e.latLng.lat()+" , "+e.latLng.lng());

                    var request = {
                        placeId: e.placeId,
                        fields: ['name']
                    };


                    var infowindow = new google.maps.InfoWindow();
                    var service = new google.maps.places.PlacesService(map);

                    service.getDetails(request, function(place, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            console.log(place);
                            $('#address-input').val(place.name);
                        }
                        else {
                            $('#address-input').val(e.latLng.lat()+" , "+e.latLng.lng());
                        }
                    });

                    });


                marker.setVisible(isEdit);

                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.key = fieldKey;
                autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
            }

            for (let i = 0; i < autocompletes.length; i++) {
                const input = autocompletes[i].input;
                const autocomplete = autocompletes[i].autocomplete;
                const map = autocompletes[i].map;
                const marker = autocompletes[i].marker;

                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    marker.setVisible(false);
                    const place = autocomplete.getPlace();

                    geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            setLocationCoordinates(autocomplete.key, lat, lng);
                        }
                    });

                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'");
                        input.value = "";
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                });
            }
        }

        function setLocationCoordinates(key, lat, lng) {
            const latitudeField = document.getElementById(key + "-" + "latitude");
            const longitudeField = document.getElementById(key + "-" + "longitude");
            latitudeField.value = lat;
            longitudeField.value = lng;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}&libraries=places&callback=initialize" async defer></script>
    <script>
        function formValidate(){
            var problem = $('#select');
            var group = $('#selectGroup');
            var lat = $('#address-latitude');
            var lng = $('#address-longitude');
            var validationFails = false;
            /*if(problem.val()==null){
                validationFails=true;
                $.notify("Select a problem to address",'error');
            }
            if(group.val()==null){
                validationFails=true;
                $.notify("Select a group to address",'error');
            }*/

            if(lat.val()=="0" || lng.val()==0)
            {
                validationFails=true;
                $.notify("Select your location",'error');
            }

            return !validationFails;
        }
    </script>
@endsection
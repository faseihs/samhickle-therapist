@extends('layouts.dashboard.therapist')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.3.1/dist/multiple-select.min.css">

@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Edit Profile</li>
    </ol>
    @include('includes.flash')
    @include('includes.errors')
    <form onsubmit="return formValidate()" id="formID" action="/therapist/edit-profile" method="post" enctype="multipart/form-data">
        @csrf
    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Basic info</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Profile Link</label>
                    <input style="background: white;" type="text" name="name" value="{{$therapist->getLink()}}" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{$therapist->name}}" class="form-control" placeholder="Your name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{$therapist->email}}" class="form-control" placeholder="Your email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>About</h6>
            </div>
            <div class="col-md-12">
                <textarea name="about" rows="10" class="form-control" required  >{{$therapist->profile->about}}</textarea>
            </div>
        </div>
        <!-- /row-->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Contact</label>
                    <input type="text" name="contact" class="form-control" value="{{$therapist->profile->contact}}" placeholder="Your contact number">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" accept="image/*" name="dp" class="form-control" >
                </div>
            </div>
        </div>
        @if($profile->dp)
        <div id="imgDiv" class="row text-center">
            <div class="col-md-4 col-md-offset-4"><img  {{--style="width:300px;height:300px;"--}}  class="img-responsive" src="{{$profile->dp? '/'.$profile->dp: 'https://ui-avatars.com/api/?name='.urlencode($therapist->name)}}" >

            </div>

                <div class="col-md-2 text-left">
                    <button id="delBtn" type="button" class="btn btn-primary btn-sm">
                        <i class="fa fa-eraser"></i> Delete Photo
                    </button>
                </div>

        </div>
        @endif

       {{-- <div class="row">
            <div class="col-md-6">
                <button class="btn_1"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>--}}
    </div>

    <!-- /box_general-->

    {{--<div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-map-marker"></i>Address</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>City</label>
                    <input class="form-control" name="city" placeholder="Your City" value="{{$profile->city}}" type="text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" value="{{$profile->address}}" placeholder="Your address">
                </div>
            </div>
        </div>
        <!-- /row-->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>State</label>
                    <input type="text" class="form-control" name="state" value="{{$profile->state}}" placeholder="Your state">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Zip code</label>
                    <input type="text" class="form-control" name="postal_code" value="{{$profile->postal_code}}" placeholder="Your zip code">
                </div>
            </div>
        </div>
        <!-- /row-->
    </div>--}}
    <!-- /box_general-->


    <!-- /box_general-->
    <!-- /box_general-->
        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-map-marker"></i>Therapy Information</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>What do I need help with</h6>
                        </div>
                        <div class="col-md-12">
                            <select  name="problems[]" id="select" multiple="multiple">
                                @foreach($problems as $p)
                                    <option {{$therapist->problems()->where('problems.id',$p->id)->first()?'selected':''}} value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Who is the therapy for?</h6>
                        </div>
                        <div class="col-md-12">
                            <select   name="groups[]" id="selectGroup" multiple="multiple">
                                @foreach($groups as $p)
                                    <option {{$therapist->groups()->where('groups.id',$p->id)->first()?'selected':''}} value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <h6>Types of therapy</h6>
                </div>
                <div class="col-md-12">
                    <textarea placeholder="Seperated By Comma" name="types_of_therapy" class="form-control"   >{{$therapist->profile->types_of_therapy}}</textarea>
                </div>
                <div class="col-md-12 mt-2">
                    <h6>How I deliver therapy</h6>
                </div>
                <div class="col-md-12">
                    <textarea placeholder="Seperated By Comma" name="deliveries" class="form-control"   >{{$therapist->profile->deliveries}}</textarea>
                </div>

            </div>
        </div>

        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-folder"></i>Services</h2>
            </div>
            <div class="row">

                <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <h6>Price Statement</h6>
                            </div>
                            <div class="col-md-12">
                                <textarea name="price_statement" class="form-control" required  >{{$therapist->profile->price_statement}}</textarea>
                            </div>

                        </div>


                    <h6>Treatments</h6>
                    <table id="pricing-list-container" style="width:100%;">
                        @foreach($services as $s)
                            <tr id="service{{$s->id}}" class="pricing-list-item">
                                <td>

                                    <div  class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{$s->service}}" name="services[]" class="form-control s-title" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" value="{{$s->price}}" class="form-control s-price"  placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="button" onclick="delSevice({{$s->id}})" class="btn btn-sm btn-danger btn-circle"><i class="fa fa-fw fa-remove"></i></button>
                                                <button type="button" onclick="updateService({{$s->id}})" class="btn btn-sm btn-info btn-circle" href="#"><i class="fa fa-fw fa-edit"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <a href="#0" class="btn_1 gray add-service"><i class="fa fa-fw fa-plus-circle"></i>Add Item</a>




                </div>
            </div>
            <!-- /row-->
        </div>

        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-folder"></i>Education</h2>
            </div>
            <div class="row">

                <div class="col-md-12">

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Main Speciality</h6>
                            </div>
                            <div class="col-md-12">
                                <textarea name="personal_statement" class="form-control"   >{{$therapist->profile->personal_statement}}</textarea>
                            </div>
                            <div class="col-md-12">
                                <h6>Education  Statement</h6>
                            </div>
                            <div class="col-md-12">
                                <textarea name="education_statement" class="form-control"   >{{$therapist->profile->education_statement}}</textarea>
                            </div>
                            <input name="redirectPath" value="/therapist/education" type="hidden">
                        </div>


                    <h6>Curriculum</h6>
                    <table id="pricing-list-container-2" style="width:100%;">
                        @foreach($educations as $e)
                            <tr id="education{{$e->id}}" class="pricing-list-item">
                                <td>

                                    <div  class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" value="{{$e->college}}" name="educations[]" class="form-control e-title" placeholder="College">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" value="{{$e->description}}" class="form-control e-price"  placeholder="Degree">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="button" onclick="delEducation({{$e->id}})" class="btn btn-sm btn-danger btn-circle"><i class="fa fa-fw fa-remove"></i></button>
                                                <button type="button" onclick="updateEducation({{$e->id}})" class="btn btn-sm btn-info btn-circle" href="#"><i class="fa fa-fw fa-edit"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <button  type="button" class="btn_1 gray add-education"><i class="fa fa-fw fa-plus-circle"></i>Add Item</button>


                </div>
            </div>
            <!-- /row-->
        </div>

        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-map-marker"></i>Address</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" value="{{$profile->city}}" class="form-control" placeholder="Your address">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="{{$profile->address}}" class="form-control" placeholder="Your address">
                    </div>
                </div>
            </div>
            <!-- /row-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" value="{{$profile->state}}" class="form-control" placeholder="Your state">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Zip code</label>
                        <input type="text" name="postal_code" value="{{$profile->postal_code}}" class="form-control" placeholder="Your zip code">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h6 >Location</h6>
                    <input autocomplete="nope" autofill="nope" value="{{$profile->location_name}}" type="text" id="address-input" name="address_address" class="form-control map-input">
                    <input value="{{$profile->latitude}}" type="hidden" name="address_latitude" id="address-latitude" value="0" />
                    <input value="{{$profile->longitude}}" type="hidden" name="address_longitude" id="address-longitude" value="0" />

                </div>
            </div>

            <div class="row mt-2">
                <div id="address-map-container" style="width:100%;height:400px; ">
                    <div style="width: 100%; height: 100%" id="address-map"></div>
                </div>
            </div>
            <!-- /row-->
        </div>

        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-map-marker"></i>Change Password</h2>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password"  id="password1" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  placeholder="Your password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password"  id="password2" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" placeholder="Confirm password">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @enderror
            </div>

        </div>


            <hr>

    <p><button class="btn_1 medium">Save</button></p>
    </form>


@endsection

@section('title')
    | Edit Profile
@endsection

@section('scripts')
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
        $('#delBtn').click(function () {
            $('#imgDiv').remove();
            $('#formID').append("<input type='hidden' name='delPic' value='1' />")
        });
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

                const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || {{$profile->latitude?$profile->latitude:51.507}};
                const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || {{$profile->longitude?$profile->longitude:0.127}};

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
    <script src="/js/notify.min.js"></script>

    <script>
        function formValidate(){

            var lat = $('#address-latitude');
            var lng = $('#address-longitude');
            var validationFails = false;
            if(lat.val()=="0" || lng.val()==0)
            {
                validationFails=true;
                $.notify("Select your location",'error');
            }

            return !validationFails;
        }
        var csrf='{{csrf_token()}}'
    </script>
    <script src="/js/edit-profile.js?v=1"></script>

@endsection
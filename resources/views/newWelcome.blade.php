@extends('layouts.therapist')


@section('content')

    <div class="hero_home version_1" style="background: #3f4079 url('/theme/img/bg.jpg') no-repeat center center;
		background-size: cover;">
        <div class="content">
            <h3 class="customText">Find a therapist near you</h3>
            <p class="customText">
                Search, Compare and Book
            </p>
            <form id="searchForm" onsubmit="return validateForm()" method="get" action="/search">
                <div id="custom-search-input">
                    <div class="row add_bottom_30">
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <select required class="form-control" name="problem_id" id="country">
                                    <option selected disabled value="">What do you need help with?</option>
                                    @foreach($problems as $index=>$problem)
                                        <option value="{{$index}}">{{$problem}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 ">
                            <div class="form-group">
                                <select required class="form-control" name="group_id" id="country">
                                    <option selected disabled value="">Who is the therapy for?</option>
                                    @foreach($groups as $index=>$group)
                                        <option value="{{$index}}">{{$group}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-2" >

                           {{-- <div id="postCodeDiv" class="form-group">
                                <input type="text" class="form-control" placeholder="Enter Postcode ....">

                            </div>--}}
                            <input id="locationLatLng" name="latLng" type="hidden">

                            <div class="input-group" id="locationDiv">
                                <input id="locationName" autocomplete="off" type="text" class="form-control" onfocus="initMap()" placeholder="Select Location">
                                <span class="input-group-addon input-group-addon-btn">
            <button onclick="getLocation()" id="lBtn" class="px-2" type="button"><i class="fa fa-location-arrow" aria-hidden="true"></i></button>
        </span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <input style="height:25px;position: relative"  type="submit" class="form-control pl-0 pr-0" value="Search">
                        </div>
                        <style>
                            .input-group-addon-btn {
                                padding: 0;
                                background: transparent;
                            }
                            #lBtn{
                                position: absolute;
                                right: 0;
                                background: white;
                                border:none;
                                top:10%;
                                cursor: pointer;
                                color:#74d1c6;
                            }


                        </style>


                    </div>

                    <!-- <ul>
                        <li>
                            <input type="radio" id="all" name="radio_search" value="all" checked>
                            <label for="all">All</label>
                        </li>
                        <li>
                            <input type="radio" id="doctor" name="radio_search" value="doctor">
                            <label for="doctor">Doctor</label>
                        </li>
                        <li>
                            <input type="radio" id="clinic" name="radio_search" value="clinic">
                            <label for="clinic">Clinic</label>
                        </li>
                    </ul> -->
                </div>
            </form>
        </div>
    </div>
    <!-- /Hero -->

    <div class="container margin_120_95">
        <div class="main_title text-uppercase">
            <h2>Book an <strong>online</strong> appointment WITH A THERAPIST TODAY</h2>
        </div>
        <div class="row add_bottom_30">
            <div class="col-lg-4">
                <div class="box_feat" id="icon_1">
                    <span></span>
                    <h3>FIND A THERAPIST
                    </h3>
                <p>
                    Simply enter what you need help with, who the therapy is for and your postcode. We will then search nearby therapists.
                </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box_feat" id="icon_2">
                    <span></span>
                    <h3>VIEW PROFILE
                    </h3>
                <p>
                    Browse and compare therapists profiles online. See their specialities, prices, availability and read their reviews.

                </p></div>
            </div>
            <div class="col-lg-4">
                <div class="box_feat" id="icon_3">
                    <h3>BOOK A VISIT
                    </h3>
                <p>
                    Booking a therapist couldn’t be easier. Simply click on their availability and book on online or request an appointment.


                </p></div>
            </div>
        </div>
        <!-- /row -->
{{--
        <p class="text-center"><a href="#" class="btn_1 medium">Find Doctor</a></p>
--}}

    </div>
    <!-- /container -->


    <!-- /white_bg -->


    <!-- /container -->

    <div id="app_section">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <p><img src="/theme/img/app_img.svg" alt="" class="img-fluid" width="500" height="433"></p>
                </div>
                <div class="col-md-6">
                    <small>Application</small>
                    <h3>Download <strong>THERAPIST.CO.UK APP</strong></h3>

                        <ul style="list-style-type: disc;list-style-position:inside">
                        <li>Find nearby therapists
                        </li>
                        <li>
                            Browse therapist profiles and reviews
                        </li>
                        <li>
                            Book therapist appointments with a tap

                        </li>
                    </ul>

                    <div class="app_buttons wow" data-wow-offset="100">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 43.1 85.9" style="enable-background:new 0 0 43.1 85.9;" xml:space="preserve">
							<path stroke-linecap="round" stroke-linejoin="round" class="st0 draw-arrow" d="M11.3,2.5c-5.8,5-8.7,12.7-9,20.3s2,15.1,5.3,22c6.7,14,18,25.8,31.7,33.1" />
                            <path stroke-linecap="round" stroke-linejoin="round" class="draw-arrow tail-1" d="M40.6,78.1C39,71.3,37.2,64.6,35.2,58" />
                            <path stroke-linecap="round" stroke-linejoin="round" class="draw-arrow tail-2" d="M39.8,78.5c-7.2,1.7-14.3,3.3-21.5,4.9" />
						</svg>
                        <a href="#0" class="fadeIn"><img src="/theme/img/apple_app.png" alt="" width="150" height="50" data-retina="true"></a>
                        <a href="#0" class="fadeIn"><img src="/theme/img/google_play_app.png" alt="" width="150" height="50" data-retina="true"></a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /app_section -->
    <div style="display: none;" id="map"></div>

@endsection

@section('scripts')


    <script>
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        var position=null;
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    position = {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude
                    };
                    console.log(position);
                    geocodeLatLng();

                },function errorHandler(){
                    console.log("Nooo");
                    alert("Enable location access to use location")

                });
            } else {
                alert("Browser doesn't support Geolocation");
                //locationErrorHandler();

            }
        }
        function initMap() {

            // Try HTML5 geolocation.

        }

        function locationErrorHandler(){
            geocodeLatLng();
        }

        function geocodeLatLng() {
            var geocoder = new google.maps.Geocoder;
            if(position==null)
                position={
                    lat:51.5072686,
                    lng:0.12737540000000536,
                };
            geocoder.geocode({'location': position}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var addressName=results[0].formatted_address;
                        $('#locationName').val(addressName);
                        $('#locationLatLng').val(JSON.stringify(position));
                        console.log(JSON.stringify(results));
                        console.log(results);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }



    </script>
    <div style="display: none;" id="map"></div>
    <script src="/js/notify.min.js"></script>

    <script>
        function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -33.8688, lng: 151.2195},
                zoom: 13,
                mapTypeId: 'roadmap'
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('locationName');
            var searchBox = new google.maps.places.Autocomplete(input,{
                types: ['(regions)']
            });
            searchBox.setComponentRestrictions(
                {'country': ['gb']});
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('place_changed', function() {

                var places = searchBox.getPlace();
                console.log(places);

                if (!places.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.

                    return;
                }
                else {
                    $('#locationName').val(places.formatted_address);
                    $('#locationLatLng').val(JSON.stringify(places.geometry.location));
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];
                place=places;
                places=[];
                places.push(place);
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
        function validateForm(){
            var latLng= $('#locationLatLng');
            success=false;
            if(latLng.val().length<1){
                {
                    var geocoder = new google.maps.Geocoder;

                        position={
                            lat:51.5072686,
                            lng:0.12737540000000536,
                        };
                    geocoder.geocode({'location': position}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                var addressName=results[0].formatted_address;
                                $('#locationName').val(addressName);
                                $('#locationLatLng').val(JSON.stringify(position));
                                console.log(latLng.val());
                                $('#searchForm').submit();
                            } else {
                                $.notify("Select Location","error")
                                window.locationSuccess= false;
                            }
                        } else {
                            $.notify("Select Location","error")
                            window.locationSuccess= false;
                        }
                    });
                }

            }
            else success=true;


            return success;
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API')}}&libraries=places&callback=initAutocomplete"
            async defer></script>

    <style>
        #locationName:after{display:none !important;}
        .pac-container:after {
            /* Disclaimer: not needed to show 'powered by Google' if also a Google Map is shown */

            background-image: none !important;
            height: 0px;
        }
        .pac-container{
            font-family: inherit;
        }
        .pac-item{
            cursor: pointer;

        }
    </style>




@endsection

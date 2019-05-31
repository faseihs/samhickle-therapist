@extends('layouts.therapist')


@section('title',' | Search Results')


@section('styles')

    <link href="/theme/css/date_picker.css" rel="stylesheet">
@endsection


@section('scripts')

    <script
            src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API')}}">
    </script>
    <script src="/theme/js/markerclusterer.js"></script>
   {{-- <script src="/theme/js/map_listing.js"></script>--}}
    <script>
        var
            mapObject,
            markers = [],
            markersData = {
                'Doctors': JSON.parse('{!!  $mapsData!!}')
            };

        var mapOptions = {
            zoom: 10,
            center: new google.maps.LatLng({{$input['latlng']->lat}}, {{$input['latlng']->lng}}),
            mapTypeId: google.maps.MapTypeId.ROADMAP,

            mapTypeControl: false,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            panControl: false,
            panControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            scrollwheel: false,
            scaleControl: false,
            scaleControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            styles: [
                {
                    "featureType": "landscape",
                    "stylers": [
                        {
                            "hue": "#FFBB00"
                        },
                        {
                            "saturation": 43.400000000000006
                        },
                        {
                            "lightness": 37.599999999999994
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "stylers": [
                        {
                            "hue": "#FFC200"
                        },
                        {
                            "saturation": -61.8
                        },
                        {
                            "lightness": 45.599999999999994
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "stylers": [
                        {
                            "hue": "#FF0300"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": 51.19999999999999
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "stylers": [
                        {
                            "hue": "#FF0300"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": 52
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "stylers": [
                        {
                            "hue": "#0078FF"
                        },
                        {
                            "saturation": -13.200000000000003
                        },
                        {
                            "lightness": 2.4000000000000057
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "stylers": [
                        {
                            "hue": "#00FF6A"
                        },
                        {
                            "saturation": -1.0989010989011234
                        },
                        {
                            "lightness": 11.200000000000017
                        },
                        {
                            "gamma": 1
                        }
                    ]
                }
            ]
        };
        var
            marker;
        mapObject = new google.maps.Map(document.getElementById('map_listing'), mapOptions);
        for (var key in markersData)
            markersData[key].forEach(function (item) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
                    map: mapObject,
                    icon: '/theme/img/pins/' + key + '.png',
                });

                if ('undefined' === typeof markers[key])
                    markers[key] = [];
                markers[key].push(marker);
                google.maps.event.addListener(marker, 'click', (function () {
                    closeInfoBox();
                    getInfoBox(item).open(mapObject, this);
                    mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
                }));


            });

        function hideAllMarkers () {
            for (var key in markers)
                markers[key].forEach(function (marker) {
                    marker.setMap(null);
                });
        };

        function toggleMarkers (category) {
            hideAllMarkers();
            closeInfoBox();

            if ('undefined' === typeof markers[category])
                return false;
            markers[category].forEach(function (marker) {
                marker.setMap(mapObject);
                marker.setAnimation(google.maps.Animation.DROP);

            });
        };

        new MarkerClusterer(mapObject, markers[key]);

        function hideAllMarkers () {
            for (var key in markers)
                markers[key].forEach(function (marker) {
                    marker.setMap(null);
                });
        };

        function closeInfoBox() {
            $('div.infoBox').remove();
        };

        function getInfoBox(item) {
            return new InfoBox({
                content:
                '<div class="marker_info">' +
                '<figure><a href='+ item.url_detail +'><img src="' + item.map_image_url + '" alt="Image"></a></figure>' +
                '<small>'+ item.type +'</small>' +
                '<h3><a href='+ item.url_detail +'>'+ item.name_point +'</a></h3>' +
                '<span>'+ item.description_point +'</span>' +
                '<div class="marker_tools">' +
                '<form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block""><input name="saddr" value="'+ item.get_directions_start_address +'" type="hidden"><input type="hidden" name="daddr" value="'+ item.location_latitude +',' +item.location_longitude +'"><button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button></form>' +
                '<a href="tel://'+ item.phone +'" class="btn_infobox_phone">'+ item.phone +'</a>' +
                '</div>' +
                '</div>',
                disableAutoPan: false,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(10, 105),
                closeBoxMargin: '',
                closeBoxURL: "/theme/img/close_infobox.png",
                isHidden: false,
                alignBottom: true,
                pane: 'floatPane',
                enableEventPropagation: true
            });
        };

        function onHtmlClick(location_type, key) {
            google.maps.event.trigger(markers[location_type][key], "click");
        }
    </script>
    <script src="/theme/js/infobox.js"></script>

@endsection

@section('content')
    <div id="results">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4><strong>Showing {{sizeof($therapists)<$perPage?sizeof($therapists):$perPage}}</strong> of {{$total}} results</h4>
                </div>
                {{--<div class="col-md-6">
                    <div class="search_bar_list">
                        <input type="text" class="form-control" placeholder="Ex. Specialist, Name, Doctor...">
                        <input type="submit" value="Search">
                    </div>
                </div>--}}
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /results -->

    {{--<div class="filters_listing">
        <div class="container">
            <ul class="clearfix">
                <li>
                    <h6>Type</h6>
                    <div class="switch-field">
                        <input type="radio" id="all" name="type_patient" value="all" checked>
                        <label for="all">All</label>
                        <input type="radio" id="doctors" name="type_patient" value="doctors">
                        <label for="doctors">Doctors</label>
                        <input type="radio" id="clinics" name="type_patient" value="clinics">
                        <label for="clinics">Clinics</label>
                    </div>
                </li>
                <li>
                    <h6>Layout</h6>
                    <div class="layout_view">
                        <a href="#0" class="active"><i class="icon-th"></i></a>
                        <a href="list.html"><i class="icon-th-list"></i></a>
                        <a href="list-map.html"><i class="icon-map-1"></i></a>
                    </div>
                </li>
                <li>
                    <h6>Sort by</h6>
                    <select name="orderby" class="selectbox">
                        <option value="Closest">Closest</option>
                        <option value="Best rated">Best rated</option>
                        <option value="Men">Men</option>
                        <option value="Women">Women</option>
                    </select>
                </li>
            </ul>
        </div>
        <!-- /container -->
    </div>--}}
    <!-- /filters -->

    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @foreach($therapists as $t)
                    <div class="col-md-6">
                        <div class="box_list wow fadeIn">
                            <a href="#0" class="wish_bt"></a>
                            <figure>
                                <a href="detail-page.html"><img src="http://via.placeholder.com/565x565.jpg" class="img-fluid" alt="">
                                    <div class="preview"><span>Read more</span></div>
                                </a>
                            </figure>
                            <div class="wrapper">
                                <small>Therapist</small>
                                <h3>{{$t->name}}</h3>

                                <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cuodo....</p>
                                <span class="rating"><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i><i class="icon_star"></i> <small>(145)</small></span>
                                <a href="badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="/theme/img/badges/badge_1.svg" width="15" height="15" alt=""></a>
                            </div>
                            <ul>
                                <li><a href="#0" onclick="onHtmlClick('Doctors', 0)"><i class="icon_pin_alt"></i>View on map</a></li>
                                <li><a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x0:0xa6a9af76b1e2d899!2sAssistance+%E2%80%93+H%C3%B4pitaux+De+Paris!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="_blank"><i class="icon_pin_alt"></i>Directions</a></li>
                                <li><a href="detail-page.html">Book now</a></li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    @if($total<1)
                        <div class="col-md-12 alert alert-warning">
                            No Therapists Found
                        </div>

                    @endif

                    <!-- /box_list -->

                </div>
                <!-- /row -->

                <nav aria-label="" class="add_top_20">
                   {{-- <ul class="pagination pagination-sm">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>--}}
                    {{$therapists->links()}}
                    {{--{{$users->appends(request()->query())->links()}}--}}
                </nav>

                <!-- /pagination -->
            </div>
            <!-- /col -->

            <aside class="col-lg-4" id="sidebar">
                <div id="map_listing" class="normal_list">
                </div>
            </aside>
            <!-- /aside -->

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
@endsection
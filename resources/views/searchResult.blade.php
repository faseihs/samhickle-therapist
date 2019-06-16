@extends('layouts.therapist')


@section('title',' | Search Results')


@section('styles')

    <link href="/theme/css/date_picker.css" rel="stylesheet">
@endsection


@section('scripts')
    <script>
        window.auth = '{{Auth::user()?'true':'false'}}';
    </script>
    <script src="/js/profile.js?v=8"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API')}}">
    </script>
    <script src="/theme/js/markerclusterer.js"></script>
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
            console.log("Hovered");
            console.log($('#map_listing'));
        }
    </script>
    <script src="/theme/js/infobox.js"></script>

@endsection

@section('content')
    <div id="profile-schedule" class="container-fluid margin_60_35">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @foreach($therapists as $index=>$t)
                    <div  class="col-md-12">

                        <div class="strip_list wow fadeIn row">

                                <figure>
                                    <a href="/therapist-profile/{{$t->slug}}"><img style="width: 100%;" src="{{$t->profile->dp?'/'.$t->profile->dp:'http://via.placeholder.com/565x565.jpg'}}" class="img-fluid" alt="">
                                        <div class="preview"><span>Read more</span></div>
                                    </a>
                                </figure>
                                    <div class="wrapper col-md-3">
                                        <small>Therapist</small>
                                        <h5>{{$t->name}}</h5>
                                        <p><i class="fa fa-location-arrow"></i> Distance : {{number_format($t->distance,'0')}} kms</p>

                                        <p>{{$t->profile->personal_statement}}</p>
                                        <span class="rating">
                                @for($i=1;$i<=$t->getStars();$i++)
                                                <i class="icon_star voted"></i>
                                            @endfor
                                            @if(sizeof($t->reviews)>0)
                                                ({{sizeof($t->reviews)}})
                                            @endif

                                    </span>
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <a href="/therapist-profile/{{$t->slug}}"><i class="fa fa-user"></i> View Profile</a>

                                            </div>
                                            <div class="col-md-12 text-left">
                                                <a onclick="onHtmlClick('Doctors', {{$index}})" href="#"><i class="fa fa-location-arrow"></i> View On Map</a>
                                            </div>
                                        </div>
                                    </div>

                                <search-schedule slug="{{$t->slug}}">

                                </search-schedule>

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
                    {{$therapists->links()}}
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
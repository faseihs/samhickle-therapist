@extends('layouts.therapist')

@section('title')
    | {{$therapist->name}}
@endsection


@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a>Therapist</a></li>
                <li>{{$therapist->name}}</li>
            </ul>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="container margin_60">
        <div class="row">

            <aside class="col-xl-3 col-lg-4" id="sidebar">
                <div class="box_profile">
                    <figure>
                        @if($profile->dp)
                            <img src="/{{$profile->dp}}" alt="" class="img-fluid">
                        @else
                            <img src="http://via.placeholder.com/565x565.jpg" alt="" class="img-fluid">
                        @endif

                    </figure>
                    <small>Therapist</small>
                    <h1>{{$therapist->name}}</h1>
                    <span class="rating">
                        @for($i=1;$i<=$therapist->getStars();$i++)
                            <i class="icon_star voted"></i>
                        @endfor
                        @if(sizeof($therapist->reviews)>0)
                            ({{sizeof($therapist->reviews)}})
                        @endif
                    </span>
							{{--	</span>
                    <ul class="statistic">
                        <li>854 Views</li>
                        <li>124 Patients</li>
                    </ul>--}}
                    <ul class="contacts">
                        @if($therapist->profile->address)
                            <li><h6>Address</h6>{{$therapist->profile->address}}</li>
                        @endif

                        <li><h6>Phone</h6><a href="{{$therapist->profile->contact}}">{{$therapist->profile->contact}}</a></li>
                    </ul>
                    <div class="text-center"><a href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$therapist->profile->latitude}}+{{$therapist->profile->longitude}}" class="btn_1 outline" target="_blank"><i class="icon_pin"></i> View on map</a></div>
                </div>
            </aside>
            <!-- /asdide -->

            <div class="col-xl-9 col-lg-8">
                @include('includes.flash')

                <div class="tabs_styled_2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book">Book an appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-expanded="true">General info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews">Reviews</a>
                        </li>
                    </ul>
                    <!--/nav-tabs -->

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="book" role="tabpanel" aria-labelledby="book-tab">
                            <p class="lead add_bottom_30">Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            <form>
                                <div class="main_title_3">
                                    <h3><strong>1</strong>Select your date</h3>
                                </div>
                                <div class="row form-group add_bottom_45">
                                    <div class="col-md-7">
                                        <div id="calendar"></div>
                                        <input type="hidden" id="my_hidden_input">
                                    </div>
                                    <div class="col-md-5">
                                        <ul id="timesList" class="time_select version_2 add_top_20">
                                            <li>
                                                <input type="checkbox" id="radio1" name="times" value="09.30am">
                                                <label for="radio1">09.30am</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio2" name="times" value="10.00am">
                                                <label for="radio2">10.00am</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio3" name="times" value="10.30am">
                                                <label for="radio3">10.30am</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio4" name="times" value="11.00am">
                                                <label for="radio4">11.00am</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio5" name="times" value="11.30am">
                                                <label for="radio5">11.30am</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio6" name="times" value="12.00am">
                                                <label for="radio6">12.00am</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio7" name="times" value="01.30pm">
                                                <label for="radio7">01.30pm</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio8" name="times" value="02.00pm">
                                                <label for="radio8">02.00pm</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio9" name="times" value="02.30pm">
                                                <label for="radio9">02.30pm</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio10" name="times" value="03.00pm">
                                                <label for="radio10">03.00pm</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio11" name="times" value="03.30pm">
                                                <label for="radio11">03.30pm</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="radio12" name="times" value="04.00pm">
                                                <label for="radio12">04.00pm</label>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                </div>
                                <div class="main_title_3">
                                    <h3><strong>2</strong>Select your time</h3>
                                </div>
                                <div class="row justify-content-center add_bottom_45">
                                    <div class="col-md-3 col-6 text-center">
                                        <ul class="time_select">
                                            <li>
                                                <input type="radio" id="userradio1" name="userTimes" value="09.30am">
                                                <label for="userradio1">09.30am</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio2" name="userTimes" value="10.00am">
                                                <label for="userradio2">10.00am</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio3" name="userTimes" value="10.30am">
                                                <label for="userradio3">10.30am</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio4" name="userTimes" value="11.00am">
                                                <label for="userradio4">11.00am</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio5" name="userTimes" value="11.30am">
                                                <label for="userradio5">11.30am</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio6" name="userTimes" value="12.00am">
                                                <label for="userradio6">12.00am</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3 col-6 text-center">
                                        <ul class="time_select">
                                            <li>
                                                <input type="radio" id="userradio7" name="userTimes" value="01.30pm">
                                                <label for="userradio7">01.30pm</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio8" name="userTimes" value="02.00pm">
                                                <label for="userradio8">02.00pm</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio9" name="userTimes" value="02.30pm">
                                                <label for="userradio9">02.30pm</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio10" name="userTimes" value="03.00pm">
                                                <label for="userradio10">03.00pm</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio11" name="userTimes" value="03.30pm">
                                                <label for="userradio11">03.30pm</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="userradio12" name="userTimes" value="04.00pm">
                                                <label for="userradio12">04.00pm</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /row -->
                                @if(sizeof($services)>0)
                                    <div class="main_title_3">
                                        <h3><strong>3</strong>Select visit</h3>
                                    </div>
                                    <ul class="treatments clearfix">
                                        @foreach($services as $index=>$s)
                                            <li>
                                                <div class="checkbox">
                                                    <input type="checkbox" value="{{$s->id}}" class="css-checkbox" id="visit{{$index+1}}" name="service">
                                                    <label for="visit{{$index+1}}" class="css-label">{{$s->service}}<strong>{{$s->price}}</strong></label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="main_title_3">
                                    <h3><strong>4</strong>Tell about the visit</h3>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <h6>Description/Comments</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                </div>

                            </form>
                            <hr>
                            @auth('web')
                            <p class="text-center"><button type="button" onclick="saveBooking()"  class="btn_1 medium">Book Now</button></p>

                            @endauth
                            @guest('web')
                                <div class="alert alert-warning text-center">You need to login as a patient to request a booking</div>
                                <div class="text-center">
                                    <a class="btn_1" href="/login?path={{\Illuminate\Support\Facades\URL::current()}}">Login</a>
                                </div>
                            @endguest
                        </div>
                        <!-- /tab_1 -->

                        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                            {{--@if($therapist->profile->personal_statement)
                                <p class="lead add_bottom_30">{{$therapist->profile->personal_statement}}</p>

                            @endif--}}
                            @if($profile->personal_statement)
                                    <div class="indent_title_in">
                                        <i class="pe-7s-user"></i>
                                        <h3>Professional statement</h3>
                                        <p>{{$profile->personal_statement}}</p>
                                    </div>
                            @endif
                            @if(sizeof($chunk)>0)


                            <div class="wrapper_indent">
                                <h6>Specializations</h6>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="bullets">
                                            @foreach($sp1 as $s)
                                                <li>{{$s->specialization}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="bullets">
                                            @foreach($sp2 as $s)
                                                <li>{{$s->specialization}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- /row-->
                            </div>
                        @endif
                            <!-- /wrapper indent -->

                            <hr>

                            <div class="indent_title_in">
                                <i class="pe-7s-news-paper"></i>
                                <h3>Education</h3>
                                @if($profile->education_statement)
                                    <p>{{$profile->education_statement}}</p>
                                @endif

                            </div>
                            <div class="wrapper_indent">
                                @if(sizeof($educations)>0)


                                <h6>Curriculum</h6>
                                <ul class="list_edu">
                                    @foreach($educations as $e)
                                        <li><strong>{{$e->college}}</strong> - {{$e->description}}</li>
                                    @endforeach
                                </ul>
                                @endif

                            </div>
                            <!--  End wrapper indent -->

                            <hr>

                            <div class="indent_title_in">
                                <i class="pe-7s-cash"></i>
                                <h3>Prices &amp; Payments</h3>
                                @if($profile->price_statement)
                                    <p>{{$profile->price_statement}}</p>
                                @endif
                            </div>
                            @if(sizeof($services)>0)


                            <div class="wrapper_indent">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Service - Visit</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>New patient visit</td>
                                            <td>$34</td>
                                        </tr>
                                        @foreach($services as $s)
                                            <tr>
                                            <td>{{$s->service}}</td>
                                            <td>${{$s->price}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                            <!--  End wrapper_indent -->

                        </div>
                        <!-- /tab_2 -->

                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="reviews-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(sizeof($reviews)<1)
                                            <div class="alert alert-warning">No reviews yet</div>
                                        @endif
                                    </div>


                                    <div class="col-lg-3">
                                        <div id="review_summary">
                                            <strong>{{$stars}}</strong>
                                            <div class="rating">
                                                @for($i=1;$i<=$stars;$i++)
                                                    <i class="icon_star voted"></i>
                                                @endfor
                                            </div>
                                            <small>Based on {{sizeof($reviews)}} reviews</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">

                                        <div class="row">
                                            <div class="col-lg-10 col-9">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{$starsP[5]}}%" aria-valuenow="{{$starsP[5]}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3"><small><strong>5 stars</strong></small></div>
                                        </div>
                                        <!-- /row -->
                                        <div class="row">
                                            <div class="col-lg-10 col-9">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{$starsP[4]}}%" aria-valuenow="{{$starsP[4]}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3"><small><strong>4 stars</strong></small></div>
                                        </div>
                                        <!-- /row -->
                                        <div class="row">
                                            <div class="col-lg-10 col-9">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{$starsP[3]}}%" aria-valuenow="{{$starsP[3]}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3"><small><strong>3 stars</strong></small></div>
                                        </div>
                                        <!-- /row -->
                                        <div class="row">
                                            <div class="col-lg-10 col-9">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{$starsP[2]}}%" aria-valuenow="{{$starsP[2]}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3"><small><strong>2 stars</strong></small></div>
                                        </div>
                                        <!-- /row -->
                                        <div class="row">
                                            <div class="col-lg-10 col-9">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{$starsP[1]}}%" aria-valuenow="{{$starsP[1]}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3"><small><strong>1 stars</strong></small></div>
                                        </div>
                                        <!-- /row -->
                                    </div>
                                </div>
                                <!-- /row -->

                                <hr>
                                @foreach($reviews as  $r)
                                    <div class="review-box clearfix">
                                        <figure class="rev-thumb"><img
                                                    src="{{$r->user->profile->dp?'/'.$r->user->profile->dp:'http://via.placeholder.com/150x150.jpg'}}" alt="">
                                        </figure>
                                        <div class="rev-content">
                                            <div class="rating">
                                                @for($i=1;$i<=$r->stars;$i++)
                                                    <i class="icon_star voted"></i>
                                                @endfor
                                            </div>
                                            <div class="rev-info">
                                                {{$r->user->name}} – {{Carbon::parse($r->created_at)->format('F d, Y')}}:
                                            </div>
                                            <div class="rev-text">
                                                <p>
                                                    {{$r->review}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                                <hr>
                                @auth('web')
                                    @if(Auth::user()->canReview($therapist))
                                        <div class="text-right"><a href="/submit-review/{{$therapist->slug}}" class="btn_1 add_bottom_15">Submit review</a></div>

                                    @endif
                                @endauth
                            </div>
                            <!-- End review-container -->
                        </div>
                        <!-- /tab_3 -->
                    </div>
                    <!-- /tab-content -->
                </div>
                <!-- /tabs_styled -->
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
@endsection

@section('scripts')
    <!-- SPECIFIC SCRIPTS -->
    <script src="/theme/js/bootstrap-datepicker.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/notify.min.js"></script>
    <script>
        var csrf='{{csrf_token()}}';
        var slug='{{$therapist->slug}}';
        var globalDate=null;
        $('#calendar').datepicker({
            todayHighlight: true,
            daysOfWeekDisabled: [0],
            weekStart: 1,
            format: "yyyy-mm-dd",
            datesDisabled: ["2017/10/20", "2017/11/21", "2017/12/21", "2018/01/21", "2018/02/21", "2018/03/21"],
        }).on('changeDate',function (e) {
            $("input:checkbox[name=times]").each(function(){

                var checkbox= $(this);
                checkbox.prop("checked",false);
            });
            var momentDate = moment(e.date).format('YYYY-MM-DD');
            globalDate=momentDate;
            $('#selectedDate').val(momentDate);
            var loading = $.notify("Loading....",{
                autoHide: false,
                style:'bootstrap',
                className:'info',
            });
            $.ajax({
                type: 'POST',
                url:'/schedule-by-date-and-slug',
                data:{
                    _token:csrf,
                    date:momentDate,
                    slug:slug
                }
            }).done(function (data) {
                $('.notifyjs-wrapper').trigger('notify-hide');
                $("input:checkbox[name=times]").each(function(){

                    var checkbox= $(this);
                    data.time.forEach(function (item) {

                        if(checkbox.val()===item)
                            checkbox.prop('checked', true);
                    });
                });
            }).fail(function (xhr) {
                $('.notifyjs-wrapper').trigger('notify-hide');
                if(xhr.status===404)
                    $.notify("No Schedule Present....","warn")
                else $.notify("Schedule Fetch Failed....",{
                    className:'warning',
                    style:'bootstrap',
                    autoHideDelay: 2000,
                });

                var treatmentArray=[];
                $("input:checkbox[name=times]").each(function(){

                    var checkbox= $(this);
                    treatmentArray.push(checkbox.val());
                });
                var treatment=treatmentArray.join('|');


            });
        });
        @auth('web')

        function saveBooking() {


            if(globalDate==null){
                $.notify("Choose a Date....","error");
                return;
            }


            var time = $("input:radio[name=userTimes]:checked").val();
            if(time==undefined){
                $.notify("Select Time....","error");
                return;
            }

            var description  = $('#description').val();
            if(description.length<1){
                $.notify("Enter Description....","error");
                return;
            }
            var treatmentArray=[];
            $("input:checkbox[name=service]:checked").each(function(){

                var checkbox= $(this);
                treatmentArray.push(checkbox.val());
            });

            var treatment = treatmentArray.join('|');

            if(moment(globalDate).isBefore(moment().subtract(1, "days"))){
                $.notify("Past dates cannot be selected","error");
                return;
            }

            var loading = $.notify("Loading....",{
                autoHide: false,
                style:'bootstrap',
                className:'info'
            });
            $.ajax({
                type: 'POST',
                url:'/user/booking',
                data:{
                    _token:csrf,
                    time:time,
                    date:globalDate,
                    description:description,
                    treatments:treatment,
                    slug:slug

                }
            }).done(function (data) {
                $('.notifyjs-wrapper').trigger('notify-hide');
                $.notify("Added  Successfully....","success")
                resetBooking();
            }).fail(function () {
                $('.notifyjs-wrapper').trigger('notify-hide');
                $.notify("Update Failed....","error")

            });
        }

        function resetBooking() {
            $("input:checkbox[name=service]:checked").each(function(){
                var checkbox= $(this);
                checkbox.prop("checked",false);
            });
            $("input:radio[name=userTimes]:checked").prop("checked",false);
            globalDate=null;
            $('#description').val("");
        }
        @endauth
    </script>
    <style>
        #calendar .datepicker.datepicker-inline, #calendar .datepicker.datepicker-inline table {
            width: 100%;
        }
        ul.legend li {
            display: inline-block;
            position: relative;
            margin-right: 15px;
            padding-left: 30px;
        }
        ul.legend li strong {
            display: block;
            width: 20px;
            height: 20px;
            position: absolute;
            left: 0;
            top: -2px;
        }
        ul{
            list-style: none;
        }
        ul.legend li:first-child strong {
            background-color: #8ec549;
        }
        ul.legend li:last-child strong {
            background-color: #eb525b;
        }

        ul.time_select.version_2 li {
            float: left;
            width: 50%;
        }
        ul.time_select li input[type="checkbox"] {
            display: none;
            cursor: pointer;
        }
        ul.time_select li input[type="checkbox"]:checked + label {
            background-color: #333;
            color: #fff;
        }
        ul.time_select li label {
            display: inline-block;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            background-color: #f8f8f8;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            -ms-border-radius: 3px;
            border-radius: 3px;
            padding: 8px 10px 6px 10px;
            line-height: 1;
            min-width: 100px;
            margin: 5px;
            text-align: center;
            cursor: pointer;
        }
        ul.time_select li label:hover {
            background-color: #e74e84;
            color: #fff;
        }
    </style>

@endsection
@section('styles')
    <link href="/theme/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="/theme/css/date_picker.css" rel="stylesheet">
@endsection
@extends('layouts.therapist')

@section('title')
    | {{$therapist->name}}
@endsection
@section('styles')
    <link href="/theme/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="/theme/css/date_picker.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="/js/moment.min.js"></script>
    <script src="/js/profile.js"></script>
    <script>

        var currentDate=null;
        var result=null;
        var carousel =$('#myCarousel');
        var slug ='{{$therapist->slug}}';
        var csrf='{{csrf_token()}}'
        var date = '{{Carbon::now()->format('Y-m-d')}}';
        currentDate=moment(date);
        $('#myCarousel').on('slide.bs.carousel', function (e) {
            // do something…
            var tempDate=currentDate;
            if(e.direction==='right')
                tempDate.add('days',5);
            else tempDate.subtract('days',5);

            $.ajax({
                type: 'POST',
                url:'/new-schedule',
                data:{
                    _token:csrf,
                    date:tempDate.format('YYYY-MM-DD'),
                    slug:slug
                }
            }).done(function (data) {
               var div=`
               <div class="carousel-item">
                <table class="table table-striped">
                                      <thead>




               `;
                var thead='';
                var tbody='';
                data.forEach(function (i) {
                    thead+=`<th>${i.date}</th>`;

                });
                div+=thead;
                div+=tbody;
                $('.carousel-inner').append(div);

                });
            }).error(function (xhr) {
                console.log(xhr);
            });
    </script>
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
        @include('includes.errors')
        @include('includes.flash')
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <nav id="secondary_nav">
                    <div class="container">
                        <ul class="clearfix">
                            <li><a href="#section_1" class="active">General info</a></li>
                            <li><a href="#section_2">Reviews</a></li>
                            <li><a href="#sidebar">Booking</a></li>
                        </ul>
                    </div>
                </nav>
                <div id="section_1">
                    <div class="box_general_3">
                        <div class="profile">
                            <div class="row">
                                <div class="col-lg-5 col-md-4">
                                    <figure>
                                        @if($profile->dp)
                                            <img src="/{{$profile->dp}}" alt="" class="img-fluid">
                                        @else
                                            <img src="http://via.placeholder.com/565x565.jpg" alt="" class="img-fluid">
                                        @endif                                    </figure>
                                </div>
                                <div class="col-lg-7 col-md-8">
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

                                    <ul class="contacts">

                                        @if($therapist->profile->address)
                                            <li><h6>Address</h6>{{$therapist->profile->address}}</li>
                                            @endif </li>
                                        <li>
                                            <li><h6>Phone</h6><a href="{{$therapist->profile->contact}}">{{$therapist->profile->contact}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{--<div data-interval="false" id="myCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                  <table class="table table-striped">
                                      <thead>
                                        <tr id="theadDiv">
                                            <th>2019-05-06</th>
                                            <th>2019-05-06</th>
                                            <th>2019-05-06</th>
                                            <th>2019-05-06</th>
                                            <th>2019-05-06</th>
                                        </tr>
                                      </thead>
                                      <tbody id="tbodyDiv">

                                      </tbody>
                                  </table>
                                </div>

                            </div>
                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>--}}
                        <div id="profile-schedule" class="row">
                            <schedule></schedule>
                        </div>


                        <hr>

                        <!-- /profile -->
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
                    <!-- /section_1 -->
                </div>
                <!-- /box_general -->

                <div id="section_2">
                    <div class="box_general_3">
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
                        <hr>
                        <div class="text-right"><a href="submit-review.html" class="btn_1">Submit review</a></div>
                    </div>
                </div>
                <!-- /section_2 -->
            </div>
            <!-- /col -->
            <aside class="col-xl-4 col-lg-4" id="sidebar">
                <div class="box_general_3 booking">
                    <form method="POST"  action="/user/booking">
                        @csrf
                        <input name="slug" value="{{$therapist->slug}}" type="hidden">
                        <div class="title">
                            <h3>Book a Visit</h3>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input required name="date" class="form-control" type="text" id="booking_date" data-lang="en" data-min-year="2017" data-max-year="2020" data-disabled-days="10/17/2017,11/18/2017">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input required name="time" class="form-control" type="text" id="booking_time" value="9:00 am">
                                </div>
                            </div>
                        </div>
                        <!-- /row -->

                        <ul class="treatments clearfix">
                            @foreach($services as $index=>$s)
                                <li>
                                    <div class="checkbox">
                                        <input type="checkbox" value="{{$s->id}}" class="css-checkbox" id="visit{{$index+1}}" name="treatments[]">
                                        <label for="visit{{$index+1}}" class="css-label">{{$s->service}}<strong>{{$s->price}}</strong></label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        @auth('web')
                            <button  class="btn_1 full-width">Book Now</button>
                            @else
                            <a class="btn_1" href="/login?path={{\Illuminate\Support\Facades\URL::current()}}">Login to book an appointment</a>
                        @endauth

                    </form>
                </div>
                <!-- /box_general -->
            </aside>
            <!-- /asdide -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
@endsection
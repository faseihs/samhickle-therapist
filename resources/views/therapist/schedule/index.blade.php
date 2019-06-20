@extends('layouts.dashboard.therapist')

@section('title')
    | {{$therapist->name}} | Schedule
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Listing Schedule</li>
    </ol>
    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-folder"></i>Listing Schedule</h2>
        </div>
       {{-- <form onclick="return validateListing()" action="/therapist/schedule" method="POST">
            @csrf--}}
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
                <input type="hidden" name="date" id="selectedDate">
            </div>
            <div class="col-md-12">
                <ul id="timesList" class="time_select version_2 add_top_20">

                    @php($startTime=7)
                    @php($endTime=7)
                    @php($am='am')
                    @php($c=true)
                    @php($in=1)
                    @while($c)
                        @for($i=0;$i<60;)
                            <li style="width: auto;">
                            <input type="checkbox" id="radio{{$in}}" name="times" value="{{$startTime<10?'0'.$startTime:$startTime}}.{{$i==0?'00':$i}}{{$am}}">
                            <label for="radio{{$in}}">{{$startTime<10?'0'.$startTime:$startTime}}.{{$i==0?'00':$i}}{{$am}}</label>
                            </li>
                            @php($i+=15)
                            @php($in++)
                        @endfor


                        @if($startTime>11)
                            @php($am='pm')
                        @endif
                            @php($startTime++)
                        @if($startTime>12)
                            @php($startTime=1)

                        @endif

                            @if($startTime>7 && $am=='pm')
                                @php($c=false)
                            @endif


                    @endwhile
                    {{--<li>
                        <input type="checkbox" id="radio1" name="times" value="07.00am">
                        <label for="radio1">07.00am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="07.15am">
                        <label for="radio1">07:15</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="07.30am">
                        <label for="radio1">07.30am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="07.45am">
                        <label for="radio1">07.45am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="08.00am">
                        <label for="radio1">08.00am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="08.00am">
                        <label for="radio1">08.15am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="15.15am">
                        <label for="radio1">08:30</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="07.30am">
                        <label for="radio1">07.30am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="07.45am">
                        <label for="radio1">07.45am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="08.00am">
                        <label for="radio1">08.00am</label>
                    </li>

                    <li>
                        <input type="checkbox" id="radio1" name="times" value="09.30am">
                        <label for="radio1">09.30am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="09.30am">
                        <label for="radio1">09.30am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="09.30am">
                        <label for="radio1">09.30am</label>
                    </li>
                    <li>
                        <input type="checkbox" id="radio1" name="times" value="09.30am">
                        <label for="radio1">09.30am</label>
                    </li> <li>
                        <input type="checkbox" id="radio1" name="times" value="09.30am">
                        <label for="radio1">09.30am</label>
                    </li> <li>
                        <input type="checkbox" id="radio1" name="times" value="09.30am">
                        <label for="radio1">09.30am</label>
                    </li>--}}


                    {{--<li>
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
                    </li>--}}
                </ul>
            </div>
            <div class="col-md-12">
               {{-- <ul class="legend">
                    <li><strong></strong>Available</li>
                    <li><strong></strong>Not available</li>
                </ul>--}}
                <input style="visibility: hidden" id="repeat" name="repeat" type="checkbox">
                <label style="visibility: hidden" for="repeat">Repeat Schedule</label>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button onclick="saveSchedule()" class="btn_1">Save</button>
                </div>
            </div>


    </div>
@endsection

@section('scripts')
    <!-- SPECIFIC SCRIPTS -->
    <script src="/theme/js/bootstrap-datepicker.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/notify.min.js"></script>
    <script>
        var csrf='{{csrf_token()}}';
        var dates= {!! $dates !!};
        console.log(dates);
        var options ={
            todayHighlight: true,
            daysOfWeekDisabled: [],
            weekStart: 1,
            format: "yyyy-mm-dd",
            beforeShowDay: function(date) {
                console.log(date);
                var d = date;
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                var formattedDate = (curr_date<10?'0'+curr_date:curr_date) + "/" + (curr_month<10?'0'+curr_month:curr_month) + "/" + curr_year
                console.log(formattedDate);
                for(var i =0; i<dates.length;i++){
                    //console.log(moment(dates[i], "MM-DD-YYYY"))
                    //debugger;

                    if( moment(dates[i], "MM-DD-YYYY") ===  moment(formattedDate, "MM-DD-YYYY"))
                        return {
                            classes: 'bg-primary day text-white'
                        };
                }
                if ($.inArray(formattedDate, dates) != -1) {
                    return {
                        classes: 'bg-primary day text-white'
                    };
                }
                return true;
            }

        };
        $('#calendar').datepicker(options).on('changeDate',function (e) {
            console.log(e);

            var d = e.date;
            var curr_date = d.getDate();
            var curr_month = d.getMonth() + 1; //Months are zero based
            var curr_year = d.getFullYear();
            var formattedDate = (curr_date<10?'0'+curr_date:curr_month) + "/" + (curr_month<10?'0'+curr_month:curr_month) + "/" + curr_year


            $('#repeat').prop("checked",false);
            $("input:checkbox[name=times]").each(function(){

                var checkbox= $(this);
                checkbox.prop("checked",false);
            });





           var momentDate = moment(e.date).format('YYYY-MM-DD');
           $('#selectedDate').val(momentDate);
            var loading = $.notify("Loading....",{
                autoHide: false,
                style:'bootstrap',
                className:'info',
            });
            $.ajax({
                type: 'POST',
                url:'/therapist/schedule-by-date',
                data:{
                    _token:csrf,
                    date:momentDate
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
                var r = data.repeat===1?true:false;
                $('#repeat').prop("checked",r);
            }).fail(function (xhr) {
                $('.notifyjs-wrapper').trigger('notify-hide');
                if(xhr.status===404)
                    $.notify("No Schedule Present....","warn")
                else $.notify("Schedule Fetch Failed....",{
                   className:'warning',
                   style:'bootstrap',
                    autoHideDelay: 2000,
                });

                $("input:checkbox[name=times]").each(function(){

                    var checkbox= $(this);
                    checkbox.prop("checked",false);
                });


            });


        });

        function saveSchedule() {
            var date = $('#selectedDate').val();
            console.log(date);

            var times="";
            var timeArray=[];
            var repeat = $('#repeat').prop("checked")===true?1:0;
            if(date.length<1)
            {
                $.notify("Select Date....","warn");
                return;
            }
            $("input:checkbox[name=times]:checked").each(function(){
                var checkbox = $(this);
                timeArray.push(checkbox.val());
            });
            times=timeArray.join("|");
            var loading = $.notify("Loading....",{
                autoHide: false,
                style:'bootstrap',
                className:'info'
            });
            $.ajax({
                type: 'POST',
                url:'/therapist/schedule',
                data:{
                    _token:csrf,
                    times:times,
                    date:date,
                    repeat:repeat
                }
            }).done(function (data) {
                $('.notifyjs-wrapper').trigger('notify-hide');
                $.notify("Updated Successfully....","success")


                var d = new Date(date);
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                var formattedDate = (curr_date<10?'0'+curr_date:curr_date) + "/" + (curr_month<10?'0'+curr_month:curr_month) + "/" + curr_year

                $('#calendar').datepicker('destroy');
                dates.push(formattedDate);
                /*options={
                    ...options,
                    setDate: new Date(formattedDate),
                }*/
                $('#calendar').datepicker(options)

            }).fail(function () {
                $.notify("Update Failed....","error")
                $('.notifyjs-wrapper').trigger('notify-hide');

            });

        }
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
    <!-- SPECIFIC CSS -->
    <link href="/theme/css/date_picker.css" rel="stylesheet">
    <link href="/theme/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">
@endsection
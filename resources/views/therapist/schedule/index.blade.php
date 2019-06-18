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
            <div class="col-md-8">
                <div id="calendar"></div>
                <input type="hidden" name="date" id="selectedDate">
            </div>
            <div class="col-md-4">
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
        var csrf='{{csrf_token()}}'
        $('#calendar').datepicker({
            todayHighlight: true,
            daysOfWeekDisabled: [0],
            weekStart: 1,
            format: "yyyy-mm-dd",
            datesDisabled: ["2017/10/20", "2017/11/21","2017/12/21", "2018/01/21","2018/02/21","2018/03/21"],
        }).on('changeDate',function (e) {
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
                console.log(data);
                $("input:checkbox[name=times]").each(function(){

                    var checkbox= $(this);
                    data.time.forEach(function (item) {
                        console.log(checkbox.val());
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
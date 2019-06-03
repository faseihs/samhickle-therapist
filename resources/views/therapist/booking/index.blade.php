@extends('layouts.dashboard.therapist')


@section('title')
    | {{$therapist->name}} | Bookings
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Bookings</li>
    </ol>
    @include('includes.flash');
    @include('includes.errors');
    <div class="box_general">
        <div class="header_box">
            <h2 class="d-inline-block">Bookings List</h2>
            <div class="filter">
                <select onchange="window.location='/therapist/bookings?status='+this.value" name="orderby" class="selectbox">
                    <option {{$status=="all"?'selected':''}} value="all">Any status</option>
                    <option {{$status==1?'selected':''}} value="1">Approved</option>
                    <option {{$status==0  &&  $status!='all'?'selected':''}} value="0">Pending</option>
                    <option {{$status==2?'selected':''}} value="2">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="list_general">
            <ul>
                @foreach($bookings as $b)
                    <li>
                        <figure><img src="/theme/img/up.png" alt=""></figure>
                        <h4>{{$b->user->name}} <i class="{{$b->getStatus()}}">{{ucfirst($b->getStatus())}}</i></h4>
                        <ul class="booking_details">
                            <li><strong>Booking date</strong> {{Carbon::parse($b->date)->format('d F Y')}}</li>
                            <li><strong>Booking time</strong> {{Carbon::parse($b->time)->format('h.ia')}}</li>
                           {{-- <li><strong>Visits</strong> Cardiology test, Diabetic diagnose</li>--}}
                            <li><strong>Telephone</strong> {{$b->user->profile->contact?$b->user->profile->contact:'-'}}</li>
                            <li><strong>Email</strong> {{$b->user->email}}</li>
                        </ul>
                        <ul class="buttons">
                            @if($b->status!=1)
                                <li><button onclick="document.getElementById('approve{{$b->id}}').submit()"  class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Approve</button></li>
                                <form id="approve{{$b->id}}" style="display: none;" method="POST" action="/therapist/booking/{{$b->id}}">
                                    @csrf
                                    <input name="status" value="1" type="hidden">
                                </form>
                            @endif

                            @if($b->status!=2)
                                    <li><button onclick="document.getElementById('cancel{{$b->id}}').submit()" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Cancel</button></li>
                                    <form id="cancel{{$b->id}}" style="display: none;" method="POST" action="/therapist/booking/{{$b->id}}">
                                        @csrf
                                        <input name="status" value="2" type="hidden">
                                    </form>
                            @endif

                        </ul>
                    </li>
                @endforeach
            </ul>

        </div>

    </div>
    {{$bookings->appends(Input::except('page'))->links()}}
    <!-- /box_general-->
@endsection
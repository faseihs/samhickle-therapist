@extends('layouts.dashboard.user')


@section('title')
    | {{$user->name}} | Bookings
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/user/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Bookings</li>
    </ol>
    @include('includes.flash')
    @include('includes.errors')
    <div class="box_general">
        <div class="header_box">
            <h2 class="d-inline-block">Bookings List</h2>
            <div class="filter">
                <select onchange="window.location='/user/bookings?status='+this.value" name="orderby" class="selectbox">
                    <option {{$status=="all"?'selected':''}} value="all">Any status</option>
                    <option {{$status==1?'selected':''}} value="1">Approved</option>
                    <option {{$status==0  &&  $status!='all'?'selected':''}} value="0">Pending</option>
                    <option {{$status==2?'selected':''}} value="2">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="list_general">
            @if(sizeof($bookings)<1)
                <div class="col-md-12 pb-2">
                    <div class="alert alert-warning">
                        No bookings yet
                    </div>
                </div>
            @endif
            <ul>
                @foreach($bookings as $b)
                    <li>
                        <figure><img src="{{$b->therapist->profile->dp?'/'.$b->therapist->profile->dp:'/theme/img/up.png'}}" alt=""></figure>
                        <h4>{{$b->therapist->name}} <i class="{{$b->getStatus()}}">{{ucfirst($b->getStatus())}}</i></h4>
                        <ul class="booking_details">
                            <li><strong>Profile link</strong> <a target="_blank" href="/therapist-profile/{{$b->therapist->slug}}">/therapist-profile/{{$b->therapist->slug}}</a></li>
                            <li><strong>Booking date</strong> {{Carbon::parse($b->date)->format('d F Y')}}</li>
                            <li><strong>Booking time</strong> {{Carbon::parse($b->time)->format('h.ia')}}</li>
                             <li><strong>Visits</strong> {{$b->therapist->profile->address?$b->therapist->profile->address:'-'}}</li>
                            <li><strong>Telephone</strong> {{$b->therapist->profile->contact?$b->therapist->profile->contact:'-'}}</li>
                            <li><strong>Email</strong> {{$b->therapist->email}}</li>
                            @if($b->description)
                                <li><strong>Reason</strong> {{$b->description}}</li>
                            @endif
                        </ul>
                        {{--<ul class="buttons">
                            @if($user->canCancelBooking($b))
                                <li><button onclick="document.getElementById('cancel{{$b->id}}').submit()"  class="btn_1 gray delete">Cancel/Delete</button></li>
                                <form id="cancel{{$b->id}}" style="display: none;" method="POST" action="/user/booking/{{$b->id}}">
                                    @csrf
                                    <input name="status" value="3" type="hidden">
                                </form>
                            @endif

                        </ul>--}}

                    </li>
                @endforeach
            </ul>

        </div>

    </div>
    {{$bookings->appends(Input::except('page'))->links()}}
    <!-- /box_general-->
@endsection
@extends('layouts.dashboard.therapist')

@section('title')
    | {{$therapist->name}} | Reviews
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Reviews</li>
    </ol>
    <div class="box_general">
        <div class="header_box">
            <h2 class="d-inline-block">Reviews List</h2>
            <div class="filter">
                <select onchange="window.location='/therapist/reviews?type='+this.value" name="orderby" class="selectbox">
                    <option {{$type=='latest'?'selected':''}} value="latest">Latest</option>
                    <option {{$type=='oldest'?'selected':''}} value="oldest">Oldest</option>
                </select>
            </div>
        </div>
        <div class="list_general reviews">
            @if(sizeof($reviews)<1)
                <div class="col-md-12 pb-2">
                    <div class="alert alert-warning">
                        No reviews yet
                    </div>
                </div>
            @endif
            <ul>
                @foreach($reviews as $r)
                    <li>
                        <span>{{Carbon::parse($r->created_at)->format('F d Y')}}</span>
                        <span class="rating">
                             @for($i=1;$i<=$r->stars;$i++)
                                <i class="fa fa-fw fa-star yellow"></i>
                            @endfor
                        </span>
                        <figure><img src="{{$r->user->profile->dp?'/'.$r->user->profile->dp:'/admin/img/avatar1.jpg'}}" alt=""></figure>
                        <h4>{{$r->user->name}}</h4>
                        <p>{{$r->review}}</p>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
    {{$reviews->appends(Input::except('page'))->links()}}

@endsection
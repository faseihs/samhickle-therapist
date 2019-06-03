@extends('layouts.therapist')


@section('title')
    | Submit Review
@endsection

@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/therapist-profile/{{$therapist->slug}}">{{$therapist->name}}</a></li>
                <li>Submit Review</li>
            </ul>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="container margin_60_35">
        <div class="row justify-content-center">
            @include('includes.errors')
            <div class="col-lg-8">
                <div class="box_general_3 write_review">
                    <form method="POST" action="/submit-review/{{$therapist->slug}}">
                        @csrf
                    <h1>Write a review for {{$therapist->name}}</h1>
                    <div class="rating_submit">
                        <div class="form-group">
                            <label class="d-block">Overall rating</label>
                            <span class="rating">
								<input type="radio" required class="rating-input" id="5_star" name="stars" value="5"><label for="5_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="4_star" name="stars" value="4"><label for="4_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="3_star" name="stars" value="3"><label for="3_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="2_star" name="stars" value="2"><label for="2_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="1_star" name="stars" value="1"><label for="1_star" class="rating-star"></label>
							</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Your review</label>
                        <textarea required name="review" class="form-control" style="height: 180px;" placeholder="Write your review here ..."></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="checkboxes add_bottom_30 add_top_15">
                            <label class="container_check">I accept <a href="#">terms and conditions and general policy</a>
                                <input name="accept" required type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <button class="btn_1">Submit review</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
@endsection
@extends('layouts.therapist')

@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="register">
                <h1>Join Therapist.co.uk today!</h1>
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <form method="POST" action="/register">
                            @csrf
                            <div class="box_form">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Your name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" required class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Your email address">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password"  id="password1" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required placeholder="Your password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Confirm password</label>
                                    <input type="password"  id="password2" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" required placeholder="Confirm password">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div id="pass-info" class="clearfix"></div>
                                <div class="checkbox-holder text-left">
                                    <div class="checkbox_2">
                                        <input required type="checkbox" value="accept_2" id="check_2" name="check_2" checked>
                                        <label for="check_2"><span>I Agree to the <strong><a target="_blank" href="/terms">Terms &amp; Conditions</a></strong></span></label>
                                    </div>
                                </div>
                                <div class="form-group text-center add_top_30">
                                    <input class="btn_1" type="submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /register -->
        </div>
    </div>
    <style>
        .invalid-feedback{
            display: block;
        }
    </style>
@endsection

@extends('layouts.therapist')


@section('title',' | Therapist | Login')


@section('content')

    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="login-2">
                <h1>Please login</h1>
                <form action="/therapist/login" method="post">
                    @csrf
                    <div class="box_form clearfix">
                        <div class="box_login">
                            <a href="#0" class="social_bt facebook">Login with Facebook</a>
                            <a href="#0" class="social_bt google">Login with Google</a>
                            <a href="#0" class="social_bt linkedin">Login with Linkedin</a>
                        </div>
                        <div class="box_login last">
                            <div class="form-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Your email address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"  value="{{ old('password') }}" required autocomplete="email" placeholder="Your password" name="password" id="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @enderror
                                <a href="/password/reset" class="forgot"><small>Forgot password?</small></a>
                            </div>

                            <div class="form-group">
                                <input class="btn_1" type="submit" value="Login">
                            </div>
                        </div>
                    </div>
                </form>
                <style>
                    .invalid-feedback{
                        display: block;
                    }
                </style>
                <p class="text-center link_bright">Do not have an account yet? <a href="/therapist/register"><strong>Register now!</strong></a></p>
            </div>
            <!-- /login -->
        </div>
    </div>

@endsection
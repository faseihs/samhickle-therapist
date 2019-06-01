@extends('layouts.dashboard.therapist')



@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Edit Profile</li>
    </ol>
    @include('includes.flash')
    <form action="/therapist/edit-profile" method="post">
        @csrf
    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Basic info</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="email" value="{{$therapist->name}}" class="form-control" placeholder="Your name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{$therapist->email}}" class="form-control" placeholder="Your email">
                </div>
            </div>
        </div>
        <!-- /row-->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Contact</label>
                    <input type="text" class="form-control" value="{{$therapist->profile->contact}}" placeholder="Your contact number">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" accept="image/*" class="form-control" >
                </div>
            </div>
        </div>
       {{-- <div class="row">
            <div class="col-md-6">
                <button class="btn_1"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>--}}
    </div>

    <!-- /box_general-->

    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-map-marker"></i>Address</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>City</label>
                    <input class="form-control" name="city" placeholder="Your City" value="{{$profile->city}}" type="text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" value="{{$profile->address}}" placeholder="Your address">
                </div>
            </div>
        </div>
        <!-- /row-->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>State</label>
                    <input type="text" class="form-control" name="state" value="{{$profile->state}}" placeholder="Your state">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Zip code</label>
                    <input type="text" class="form-control" name="postal_code" value="{{$profile->postal_code}}" placeholder="Your zip code">
                </div>
            </div>
        </div>
        <!-- /row-->
    </div>
    <!-- /box_general-->


    <!-- /box_general-->

    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-folder"></i>Pricing</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>Treatments</h6>
                <table id="pricing-list-container" style="width:100%;">
                    <tr class="pricing-list-item">
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="services[]" class="form-control" placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Price">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <a class="delete" href="#"><i class="fa fa-fw fa-remove"></i></a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <a href="#0" class="btn_1 gray add-pricing-list-item"><i class="fa fa-fw fa-plus-circle"></i>Add Item</a>
            </div>
        </div>
        <!-- /row-->
    </div>
    <!-- /box_general-->
    <p><button class="btn_1 medium">Save</button></p>
    </form>


@endsection

@section('title')
    | Edit Profile
@endsection
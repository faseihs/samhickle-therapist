@extends('layouts.therapist')

@section('title')
    | Plans
@endsection

@section('styles')
    <!-- Modernizr -->
    <!-- SPECIFIC CSS -->
    <link href="/theme/css/tables.css" rel="stylesheet">
    <script src="/theme/js/modernizr_tables.js"></script>
@endsection

@section('scripts')
    <!-- SPECIFIC SCRIPTS -->
    <script src="/theme/js/tables_func.js"></script>
@endsection

@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Category</a></li>
                <li>Page active</li>
            </ul>
        </div>
    </div>

    <div class="margin_60_35">
        <div class="container">
            <div class="main_title">
                <h1>Pricing</h1>
            </div>
        </div>

        <ul class="pricing-list bounce-invert">
            @foreach($plans as  $index=>$plan)
                <li class="{{$index==ceil(sizeof($plans)%2)?'popular':''}}">
                    <ul class="pricing-wrapper">
                        <li data-type="monthly" class="is-visible">
                            <header class="pricing-header">
                                <h2>{{$plan->name}}</h2>

                                <div class="price">
                                    <span class="currency">&pound;</span>
                                    <span class="price-value">{{$plan->price}}</span>
                                    {{--<span class="price-duration">yos</span>--}}
                                </div>
                            </header>
                            <!-- /pricing-header -->
                            <div class="pricing-body">
                                <ul class="pricing-features">
                                    @foreach($plan->desc as $d)
                                        <li><em>{{$d}}</em></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /pricing-body -->
                            @auth('therapist')
                            <footer class="pricing-footer">
                                <a class="select-plan" href="/therapist/subscription?id={{$plan->id}}">Select</a>
                            </footer>
                                @else
                                <footer class="pricing-footer">
                                    <a class="select-plan" href="/therapist/register?plan={{$plan->id}}">Register as Therapist</a>
                                </footer>
                                @endauth
                        </li>
                    </ul>
                    <!-- /pricing-wrapper -->
                </li>
            @endforeach

            {{--<li class="popular">
                <ul class="pricing-wrapper">
                    <li data-type="monthly" class="is-visible">
                        <header class="pricing-header">
                            <h2>Popular</h2>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="price-value">60</span>
                                <span class="price-duration">mo</span>
                            </div>
                        </header>
                        <!-- /pricing-header -->
                        <div class="pricing-body">
                            <ul class="pricing-features">
                                <li><em>One Time</em> Fee</li>
                                <li><em>3</em> User</li>
                                <li><em>Lifetime</em> Availability</li>
                                <li><em>Non</em> Featured</li>
                                <li><em>30 days</em> Listing</li>
                                <li><em>24/7</em> Support</li>
                            </ul>
                        </div>
                        <!-- /pricing-body -->
                        <footer class="pricing-footer">
                            <a class="select-plan" href="#0">Select</a>
                        </footer>
                    </li>
                    <li data-type="yearly" class="is-hidden">
                        <header class="pricing-header">
                            <h2>Popular</h2>

                            <div class="price">
                                <span class="currency">$</span>
                                <span class="price-value">630</span>
                                <span class="price-duration">yr</span>
                            </div>
                        </header>
                        <!-- /pricing-header -->
                        <div class="pricing-body">
                            <ul class="pricing-features">
                                <li><em>One Time</em> Fee</li>
                                <li><em>3</em> User</li>
                                <li><em>Lifetime</em> Availability</li>
                                <li><em>Non</em> Featured</li>
                                <li><em>30 days</em> Listing</li>
                                <li><em>24/7</em> Support</li>
                            </ul>
                        </div>
                        <!-- /pricing-body -->
                        <footer class="pricing-footer">
                            <a class="select-plan" href="#0">Select</a>
                        </footer>
                    </li>
                </ul>
                <!-- /cd-pricing-wrapper -->
            </li>
            <li>
                <ul class="pricing-wrapper">
                    <li data-type="monthly" class="is-visible">
                        <header class="pricing-header">
                            <h2>Premier</h2>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="price-value">90</span>
                                <span class="price-duration">mo</span>
                            </div>
                        </header>
                        <!-- /pricing-header -->
                        <div class="pricing-body">
                            <ul class="pricing-features">
                                <li><em>One Time</em> Fee</li>
                                <li><em>5</em> User</li>
                                <li><em>Lifetime</em> Availability</li>
                                <li><em>Non</em> Featured</li>
                                <li><em>30 days</em> Listing</li>
                                <li><em>24/7</em> Support</li>
                            </ul>
                        </div>
                        <!-- /pricing-body -->
                        <footer class="pricing-footer">
                            <a class="select-plan" href="#0">Select</a>
                        </footer>
                    </li>
                    <li data-type="yearly" class="is-hidden">
                        <header class="pricing-header">
                            <h2>Premier</h2>

                            <div class="price">
                                <span class="currency">$</span>
                                <span class="price-value">950</span>
                                <span class="price-duration">yr</span>
                            </div>
                        </header>
                        <!-- /pricing-header -->
                        <div class="pricing-body">
                            <ul class="pricing-features">
                                <li><em>One Time</em> Fee</li>
                                <li><em>5</em> User</li>
                                <li><em>Lifetime</em> Availability</li>
                                <li><em>Non</em> Featured</li>
                                <li><em>30 days</em> Listing</li>
                                <li><em>24/7</em> Support</li>
                            </ul>
                        </div>
                        <!-- /pricing-body -->
                        <footer class="pricing-footer">
                            <a class="select-plan" href="#0">Select</a>
                        </footer>
                    </li>--}}
                </ul>
                <!-- /pricing-wrapper -->
            </li>
        </ul>
        <!-- /pricing-list -->
    </div>
@endsection
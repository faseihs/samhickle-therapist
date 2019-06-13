@extends('layouts.therapist')


@section('title')
    | Subscribe
@endsection


@section('content')
    {{--<div id="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Category</a></li>
                <li>Page active</li>
            </ul>
        </div>
    </div>--}}
    <!-- /breadcrumb -->

    <div class="container margin_60 ">
        @include('includes.flash')
        <div class="row justify-content-center ">
            <div class="col-md-5">
        <form id="nonce-form" novalidate  action="/therapist/subscription" method="post">
            @csrf
            <input type="hidden" id="card-nonce" name="nonce">

            {{-- <div class="form-group">
                 <label>Name on card</label>
                 <input type="text" class="form-control" id="name_card_booking" name="name_card_booking" placeholder="Jhon Doe">
             </div>--}}
            <div class="box_form">
                <p>Setup your credit or debit card</p>
            <div class="row">

                <div class="col-md-12">
                    <div id="numberId" class="form-group">
                        <label>Card number</label>
{{--
                        <input type="text" id="card_number" name="card_number" class="form-control" placeholder="xxxx - xxxx - xxxx - xxxx">
--}}
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Expiration date</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="expireId" class="form-group">
{{--
                                <input type="text" id="expire_month" name="expire_month" class="form-control" placeholder="MM">
--}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Postal Code</label>
                            <div id="postalId" class="form-group">
{{--
                                <input type="text" id="expire_month" name="expire_month" class="form-control" placeholder="MM">
--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Security code</label>
                        <div class="row">
                            <div class="col-md-8">
                                <div id="securityId" class="form-group">
                                    <input type="text" id="ccv" name="ccv" class="form-control" placeholder="CCV">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img src="/theme/img/icon_ccv.gif" width="50" height="29" alt="ccv"><small>Last 3 digits</small>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button id="sq-creditcard" class="btn_1" onclick="onGetCardNonce(event)">Pay &pound;{{$plan->price}}</button>
                </div>
            </div>
            </div>
        </form>
            </div>
        </div>
    {{--<div id="form-container">

        <div id="sq-ccbox">
            <form id="nonce-form" novalidate action="/therapist/subscription" method="post">
                @csrf
                <fieldset>
                    <div id="sq-card-number"></div>
                    <div class="third">
                        <div id="sq-expiration-date"></div>
                    </div>
                    <div class="third">
                        <div id="sq-cvv"></div>
                    </div>
                    <div class="third">
                        <div id="sq-postal-code"></div>
                    </div>
                </fieldset>
                <button id="sq-creditcard" class="button-credit-card" onclick="onGetCardNonce(event)">Pay &pound;{{$plan->price}}</button>
                <!--
                  After a nonce is generated it will be assigned to this hidden input field.
                -->
                <input type="hidden" id="card-nonce" name="nonce">
                --}}{{--<div id="name_card_booking" class="form-group">
                    <label>Name on card</label>
                    <input type="text" class="form-control"  name="name_card_booking" placeholder="Jhon Doe">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Card number</label>
                            <input type="text" id="sq-card-number"> name="card_number" class="form-control" placeholder="xxxx - xxxx - xxxx - xxxx">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Expiration date</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="expire_month" name="expire_month" class="form-control" placeholder="MM">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="expire_year" name="expire_year" class="form-control" placeholder="Year">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Security code</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="sq-cvv" name="ccv" class="form-control" placeholder="CCV">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <img src="/theme/img/icon_ccv.gif" width="50" height="29" alt="ccv"><small>Last 3 digits</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <button id="sq-creditcard" class="button-credit-card" onclick="onGetCardNonce(event)">Pay $1.00</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="card-nonce" name="nonce">--}}{{--
            </form>
        </div> <!-- end #sq-ccbox -->
    </div> <!-- end #form-container -->--}}


@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.squareup.com/v2/paymentform">
    </script>

    <script>
        const applicationId = "{{env('APP_ENV')=='local'?env('SQUARE_SANDBOX_ID'):env('SQUAUE_APPLICATION_ID')}}";

        // onGetCardNonce is triggered when the "Pay $1.00" button is clicked
        function onGetCardNonce(event) {
// Don't submit the form until SqPaymentForm returns with a nonce
            event.preventDefault();
// Request a nonce from the SqPaymentForm object
            paymentForm.requestCardNonce();
        }

        // Create and initialize a payment form object
        const paymentForm = new SqPaymentForm({
// Initialize the payment form elements
            applicationId: applicationId,
            inputClass: 'form-control',
            autoBuild:true,
            cardNumber: {
                elementId: 'numberId',
                placeholder: 'Card Number'
            },
            cvv: {
                elementId: 'securityId',
                placeholder: 'CVV'
            },
            expirationDate: {
                elementId: 'expireId',
                placeholder: 'MM/YY'
            },
            postalCode: {
                elementId: 'postalId',
                placeholder: 'Postal'
            },

// SqPaymentForm callback functions
            callbacks: {
                /*
                * callback function: cardNonceResponseReceived
                * Triggered when: SqPaymentForm completes a card nonce request
                */
                cardNonceResponseReceived: function (errors, nonce, cardData) {
                    if (errors) {
                        // Log errors from nonce generation to the browser developer console.
                        console.error('Encountered errors:');
                        errors.forEach(function (error) {
                            console.error('  ' + error.message);
                        });
                        alert('Credentials Invalid');
                        return;
                    }

                    $('#card-nonce').val(nonce);
                    $('#nonce-form').submit();
                    // Uncomment the following block to
                    // 1. assign the nonce to a form field and
                    // 2. post the form to the payment processing handler
                    /*
                    document.getElementById('card-nonce').value = nonce;
                    document.getElementById('nonce-form').submit();
                    */
                }
            }
        });
    </script>
@endsection
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<link href="{{asset('css/style.css')}}" rel="stylesheet">
<style>
     .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px ;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
     
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
<div class="container">
    <h3 class="h3">Products</h3>
    <div class="row">
        <div class="col-md-8 col-sm-6 offset-md-2">
            <div class="product-grid">
               
                <div class="product-content">
                    <h3 class="title"><a href="#">{{$product->name}}</a></h3>
                    <div class="price">${{$product->price}}
                                     
                        </div>
                      <p>{{$product->description}} </p>      
                </div>
            </div>
        </div>


    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    You will be charged ${{ number_format($product->price, 2) }} for {{ $product->name }} Product
                </div>
  
                 @if(session('message'))
                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger d-none" role="alert">{{ session('error') }}</div>
            @endif
                <div class="card-body">
  
                    <form id="payment-form" class="card-form mt-3 mb-3"action="{{ route('products.payment') }}" method="POST">
                        @csrf
                          <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="payment_method" class="payment-method">
                   
                        <div class="col-lg-8 col-md-8">
                           <input class="StripeElement mb-3" name="card_holder_name" placeholder="Card holder name" required>
                            <div id="card-element"></div>
                        </div>
                        <div id="card-errors" role="alert"></div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary pay">
                                Purchase
                            </button>
                        </div>
  
                    </form>
  
                </div>
            </div>
        </div>
    </div>
</div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
  
                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                  
                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>


        <script src="https://js.stripe.com/v3/"></script>

<script>
    let stripe = Stripe("{{ env('STRIPE_KEY') }}")
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
    let card = elements.create('card', {style: style})
    card.mount('#card-element')
    let paymentMethod = null
    $('.card-form').on('submit', function (e) {
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('.card_holder_name').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                $('.payment-method').val(paymentMethod)
                $('.card-form').submit()
            }
        })
        return false
    })
</script>
    </body>
</html>

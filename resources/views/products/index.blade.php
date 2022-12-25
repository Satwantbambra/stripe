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
<link href="{{asset('css/style.css')}}" rel="stylesheet">

     
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
      @forelse ($products as $key => $product)
        <div class="col-md-3 col-sm-6">
            <div class="product-grid">
               
                <div class="product-content">
                    <h3 class="title"><a href="#">{{$product->name}}</a></h3>
                    <div class="price">${{$product->price}}

                    </div>
                    <a href="{{url('products')}}/{{$product->id}}" class="btn btn-success">   Buy Now </a>
                </div>
            </div>
        </div>
    @empty
    
    <p>No product found</p>

        @endforelse

    </div>
</div>
<hr>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
  
                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                  
                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

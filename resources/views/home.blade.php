@extends('layouts.shop')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>

 -->


<!-- HOME -->
    <div id="home">
        <!-- container -->
        <div class="container">
            <!-- home wrap -->
            <div class="home-wrap">
                <!-- home slick -->
                <div id="home-slick">
                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('images/banner01.jpg') }}" alt="">
                        <div class="banner-caption text-center">
                            <h1>Bags sale</h1>
                            <h3 class="white-color font-weak">Up to 50% Discount</h3>
                            <a href="{{route('product.index')}}"><button class="primary-btn">Shop Now</button></a>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('images/banner02.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="primary-color">HOT DEAL<br><span class="white-color font-weak">Up to 50% OFF</span></h1>
                            <a href="{{route('product.index')}}"><button class="primary-btn">Shop Now</button></a>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('images/banner03.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="white-color">New Product <span>Collection</span></h1>
                            <a href="{{route('product.index')}}"><button class="primary-btn">Shop Now</button></a>
                        </div>
                    </div>
                    <!-- /banner -->
                </div>
                <!-- /home slick -->
            </div>
            <!-- /home wrap -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOME -->


@endsection

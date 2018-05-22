@extends('layouts.app')

@section('content')
    <div class="container">
        <!--home page !-->

        <div id="home">
            <div id="carousel" class="carousel slide">

                <ol class="carousel-indicators">
                    <li class="active" data-target="#carousel" data-slide-to="0"></li>
                    <li data-target="#carousel" data-slide-to="1"></li>
                    <li data-target="#carousel" data-slide-to="2"></li>
                </ol>

                <div class="carousel-inner">
                    <div class="item active">
                        <img src="{{ asset('images/banner.png') }}" alt="">
                        <div class="carousel-caption">

                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('images/banner.png') }}" alt="">
                        <div class="carousel-caption">

                        </div>
                    </div>
                    <div class="item">
                        <img src="{{ asset('images/banner.png') }}" alt="">
                        <div class="carousel-caption">

                        </div>
                    </div>
                </div>
                <a href="#carousel" class="left carousel-control" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a href="#carousel" class="right carousel-control" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>

                </a>

            </div>
        </div>
    </div>
@endsection
            

@extends('generic::front.layouts.master')

@section('content')
    @if(!$currentArea)
        {{-- area detect popup  --}}
        @include('generic::front.layouts.area-detection-popup')
        {{--End of  area detect popup --}}
    @endif

    <div class="category_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h5 class="h5_bread_crumbs"><a href="{{route('home')}}">{{trans('global.home')}} </a></h5>
                    <i class="fa fa-caret-left class_arrow" aria-hidden="true"></i>
                    <h5>{{ $title }}</h5>
                </div>
            </div>

            <!-- <div id="owl-demo" class="owl-carousel owl-theme"> -->
            <div class="row">
                <div style="min-height: 200px">
                    {!! $about !!}
                </div>

            </div>
            <!-- </div> -->
        </div>
    </div>
@endsection


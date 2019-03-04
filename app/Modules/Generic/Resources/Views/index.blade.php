@extends('generic::layouts.master')
@section('breadcrumb')
    <ul class="page-breadcrumb breadcrumb">
        <li>
            Dashboard
        </li>
    </ul>
@endsection


@section('content')

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span >{{$article_count}}</span>
                                <small class="font-green-sharp"> </small>
                            </h3>
                            <small>Articles</small>
                        </div>
                        <div class="icon">
                            <i class="icon-like"></i>
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-purple-soft">
                                <span >{{$article_feature_count}}</span>
                            </h3>
                            <small>Feature Articles</small>
                        </div>
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                    </div>
                </div>
        </div>


</div>
</div>
@endsection

@section('styles')

@endsection

@section('scripts')

@endsection



@extends('generic::front.layouts.master')
@section('list_title') {{ @$title }} @endsection
@section('breadcrumb')
        <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/operate') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">{{ $title }}</a>
        </li>
        </ul>
@endsection

@section('content')
    <div style="clear: both;padding-top: 50px;"></div>
    <p style="font-weight: bolder">Articles</p>
    <hr/>
    <div class="row text-center">
        <ul class="list-group col-lg-10 text-center">

            @foreach($articles as $key=> $article)
            <li class="list-group-item"><a href="{{route('listFrontArticle', [$article->id, $article->slug])}}">{{$article->title}}</a></li>
            @endforeach

        </ul>

        <div style="clear: both;float: none">{!! $articles->render()  !!}</div>

        </div>
@endsection


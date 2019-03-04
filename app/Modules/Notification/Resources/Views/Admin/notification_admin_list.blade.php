@extends('generic::layouts.list')
@section('list_title') {{ @$title }} @endsection
@section('breadcrumb')
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/operate') }}">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>{{ $title }}</li>
    </ul>
@endsection
@section('list_add_button')
    <a href="{{route('createNotification')}}" class="btn btn-lg btn-success">Create Notification</a>
@endsection
@section('page_body')
    <table class="table table-striped table-bordered table-hover" id="sample_3">
        <thead>
        <tr class="">
            <th>#</th>
            <th>Notification Title</th>
            <th>Notification ID</th>
            <th>Sent At</th>
            <th>view</th>
        </tr>
        </thead>
        <tbody>
        @foreach($notifications as $key => $notification)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td> {{$notification->title}}</td>
                <td> {{$notification->notification_id}}</td>
                <td> {{$notification->created_at}}</td>
                <td>
                    <a href="{{route('showNotification',$notification->id)}}" class="btn btn-sm blue">
                        Show stats <i class="fa fa-bar-chart"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

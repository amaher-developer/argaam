@extends('generic::layouts.list')
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
@section('list_add_button')
    <a href="{{route('createCategory')}}" class="btn btn-lg btn-success">Add Category</a>
     {{--@if(request('trashed'))--}}
            {{--<a href="{{route('listCategory')}}" class="btn btn-lg btn-info">Enabled</a>--}}
        {{--@else--}}
            {{--<a href="{{route('listCategory')}}?trashed=1" class="btn btn-lg btn-danger">Disabled</a>--}}
        {{--@endif--}}
            {{--<a href="" url="{{request()->fullUrlWithQuery(['export'=>1])}}" id="export" class="btn red btn-outline"><i class="icon-paper-clip"></i> Export</a>--}}
@endsection
@section('page_body')
    <div class="row">

        {{--<button class="btn btn-info filter_trigger_button" style="margin-bottom: 10px">Show/Hide Filters</button>--}}

        {{--<form action="" id="filter_form">--}}
            {{--<table class="table table-striped table-bordered table-hover ">--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                    {{--<th>ID</th>--}}
                    {{--<td><input id="id" value="{{ request('id')}}" name="id" class="form-control"--}}
                               {{--type="number" placeholder="ID"/></td>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
            {{--</table>--}}

            {{--<div class="row">--}}
                {{--<div class="col-md-offset-9 col-md-3">--}}
                    {{--<div class="form-group">--}}
                        {{--<button type="submit" class="btn green form-control">Apply</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


        {{--</form>--}}

        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                    <tr>
                        <th>Total Count</th>
                        <td>{{ $total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr class="">
            <th>#</th>
            <th>id</th><th>name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $key=> $category)
            <tr>
                <td> {{ $key+1 }}</td>
                <td> {{ $category->id }}</td><td> {{ $category->name }}</td>
                <td>
                    <a href="{{route('editCategory',$category->id)}}" class="btn btn-xs yellow">
                        <i class="fa fa-edit"></i>
                    </a>
                    @if(request('trashed'))
                        <a title="Enable" href="{{route('deleteCategory',$category->id)}}" class="confirm_delete btn btn-xs green">
                            <i class="fa fa-check-circle"></i>
                        </a>
                    @else
                        <a title="Disable" href="{{route('deleteCategory',$category->id)}}" class="confirm_delete btn btn-xs red">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
     <div class="col-lg-5 col-md-5 col-md-offset-5">
                {!! $categories->appends($search_query)->render()  !!}
            </div>
        </div>
@endsection

@section('scripts')
    @parent

    <script>

        $(document).on('click', '#export', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('url'),
                cache: false,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    var a = document.createElement("a");
                    a.href = response.file;
                    a.download = response.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                },
                error: function (request, error) {
                    swal("Operation failed", "Something went wrong.", "error");
                    console.error("Request: " + JSON.stringify(request));
                    console.error("Error: " + JSON.stringify(error));
                }
            });

        });

        $("#filter_form").slideUp();
        $(".filter_trigger_button").click(function () {
            $("#filter_form").slideToggle(300);
        });

        $(document).on('click', '.remove_filter', function (event) {
            event.preventDefault();
            var filter = $(this).attr('id');
            $("#" + filter).val('');
            $("#filter_form").submit();
        });


    </script>

@endsection
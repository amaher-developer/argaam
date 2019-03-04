@extends('generic::layouts.list')
@section('list_title') {{ @$title }} @endsection
@section('styles')
    <link href="{{asset('resources/assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}"
          rel="stylesheet"
          type="text/css"/>
@endsection
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
    <a href="{{route('createUser')}}" class="btn btn-lg btn-success">Add Customer</a>
@endsection
@section('page_body')
    <button class="btn btn-info filter_trigger_button">Filters</button>

    <form action="" id="filter_form">
        <div class="row">
            <div class="col-lg-2 col-md-2">
                <label class="control-label">User_id</label>
                <input id="input_user_id" value="{{ request('user_id') }}" name="user_id" class="form-control"
                       type="number" placeholder="User_id"/>
            </div>
            <div class="col-lg-2 col-md-2">
                <label class="control-label">Name</label>
                <input id="input_name" value="{{ request('name') }}" name="name" class="form-control"
                       type="text" placeholder="Name"/>
            </div>
            <div class="col-lg-2 col-md-2">
                <label class="control-label">Phone</label>
                <input id="input_phone" value="{{ request('phone') }}" name="phone" class="form-control"
                       type="text" placeholder="Phone"/>
            </div>
            <div class="col-lg-2 col-md-2">
                <label class="control-label">Email</label>
                <input id="input_email" value="{{ request('email') }}" name="email" class="form-control"
                       type="text" placeholder="Email"/>
            </div>

        </div>

        <div class="row">
            <div class="col-md-offset-9 col-md-3">
                <div class="form-group">
                    <button type="submit" class="btn green form-control">Apply</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                    <tr>
                        <th>Customer count</th>
                        <td>{{ $users_count }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover sample__" id="sample_3">
        <thead>
        <tr class="">
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    {{ $user->name }}
                    <a style="color:{{  $user->customer_preferences ? '#3399ff' : '#b8b8c8' }}"
                       href="{{ route('updatePreferences',$user->id) }}"
                       class="customer_preferences"
                       data-toggle="tooltip"
                       data-placement="right"
                       title="{!! ($user->customer_preferences) !!} "
                       customer_name="{{ $user->name }}">
                        <i class="fa fa-1x fa-info-circle"></i>
                    </a>
                </td>
                <td>{{ $user->phone }}</td>

                <td>
                    <a href="{{ route('editUser',$user->id) }}" class="btn btn-xs yellow">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ ($paginated) ? $users->links() : '' }}
    </div>

    <div class="hidden">
        <div id="export_btn">
            <a href="" id="export" class="btn red btn-outline">
                <i class="icon-paper-clip"></i> Export
            </a>
        </div>
    </div>

@endsection


@section('scripts')
    @parent

    <script>
        var export_btn = $('#export_btn').html();
        $('.trigger-tools-group').html(export_btn);
        $(document).on('click', '#export', function (event) {
            event.preventDefault();
            var url = document.location.href + "?export";
            if (document.location.href.indexOf('?') >= 0) {
                url = document.location.href + "&export";
            }
            $.ajax({
                url: url,
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


        $('#sample_3').dataTable({
            paging: false,
            info: false,
            searching: false,
            lengthChange: false
        });

        $("#filter_form").slideUp();
        $(".filter_trigger_button").click(function () {
            $("#filter_form").slideToggle(300);
//            toggleClass('hidden',300);
        });

        // $(document).on('click', '.remove_filter', function (event) {
        //     event.preventDefault();
        //     var filter = $(this).attr('id');
        //     $("#input_" + filter).val('');
        //     $("#filter_form").submit();
        // });


    </script>


    <script src="{{asset('resources/assets/admin/global/plugins/moment.min.js')}}"
            type="text/javascript"></script>
@endsection

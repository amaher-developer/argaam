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
    <a href="{{route('createArticle')}}" class="btn btn-lg btn-success">Add Article</a>
     {{--@if(request('trashed'))--}}
            {{--<a href="{{route('listArticle')}}" class="btn btn-lg btn-info">Enabled</a>--}}
        {{--@else--}}
            {{--<a href="{{route('listArticle')}}?trashed=1" class="btn btn-lg btn-danger">Disabled</a>--}}
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
        <form method="post" action="{{route('arrangeArticle')}}" class="form-horizontal" role="form" enctype="multipart/form-data">

            {{csrf_field()}}
    <table class="table table-striped table-bordered table-hover" id="sample_3">
        <thead>
        <tr class="">

            <th>#</th>
            <th>Sorting</th>
            <th>title</th><th>category</th>
            <th>Actions</th>
            <th>Select</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $key=> $article)
            <tr>

                <td> {{ $article->id }}</td>
                <td> {{ $article->sorting }}</td>
                <td> {{ $article->title }}</td><td> {{ @$article->category->name }}</td>
                <td>
                    <a href="{{route('editArticle',$article->id)}}" class="btn btn-xs yellow">
                        <i class="fa fa-edit"></i>
                    </a>
                    @if(request('trashed'))
                        <a title="Enable" href="{{route('deleteArticle',$article->id)}}" class="confirm_delete btn btn-xs green">
                            <i class="fa fa-check-circle"></i>
                        </a>
                    @else
                        <a title="Disable" href="{{route('deleteArticle',$article->id)}}" class="confirm_delete btn btn-xs red">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </td>
                <td class="selection-td"><input class="form-control hidden" type="checkbox" checked
                                                name="chosen_item[]" value="{{$article->id}}">
                    <span style="color: #0ed20e;font-weight: bold;" class="hidden">...</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
     <div class="col-lg-5 col-md-5 col-md-offset-5">
{{--                {!! $articles->appends($search_query)->render()  !!}--}}
         <div class="form-actions" style="clear:both;">
             <div class="row">
                 <div class="col-md-offset-4 col-md-9">
                     {{--<button class="btn yellow selection-done">Selection Done</button>--}}
                     <button type="submit" class="btn green sorting-done hidden">Sorting Done</button>
                 </div>
             </div>
         </div>
            </div>
        </form>
        </div>
@endsection



@section("tables")
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var fixHelperModified = function (e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function (index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function (e, ui) {
                $('td.index', ui.item.parent()).each(function (i) {
                    $(this).html(i + 1);
                });
            };


        // $(".selection-done").click(function (e) {
        //     e.preventDefault();
        $('table .selection-td input').each(function () {
            if (!$(this).is(":checked")) {
                $(this).parent().closest('tr').remove();
            }
        });
        $(".selection-done").addClass('hidden');
        $(".sorting-done").removeClass('hidden');
        $('table .selection-td input').addClass('hidden');
        $('table .selection-td span').removeClass('hidden');
        $('table tbody tr').css("cursor", "pointer");

        $("table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        }).disableSelection();
        // });
    </script>
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
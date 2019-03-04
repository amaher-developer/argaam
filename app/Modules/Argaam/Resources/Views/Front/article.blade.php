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
    <div class="form-body" style="padding-top: 60px;">

        <div class="form-group col-md-12">
            <div class="col-md-9">
                {{$article->title}}
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-9">
                {{$article->created_at}}
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-9">
                {!! $article->content !!}
            </div>
        </div>

        <div style="clear: both;"></div>
        <div class="form-group col-md-12">
            <div class="col-md-12">
                @foreach($article->images as $image)
                    <img src="{{$image}}" style="height: 200px;width: 200px;object-fit:contain;padding: 10px;">
                    @endforeach
            </div>
        </div>
        <div style="clear: both;"></div>


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
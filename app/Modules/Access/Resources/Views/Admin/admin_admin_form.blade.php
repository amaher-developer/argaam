@extends('generic::layouts.form')
@section('breadcrumb')
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ url('/operate') }}">Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('listUser') }}">Customers</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>{{ $title }}</li>
    </ul>
@endsection
@section('sub_styles')  @endsection
@section('form_title') {{ @$title }} @endsection
@section('page_body')
    <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data" id="ad_add_form">
        <div class="form-body">
            {{csrf_field()}}
            <div class="form-group">
                <label class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                    <input id="name" value="{{ old('name', $user->name) }}"
                           name="name" type="text" class="form-control"
                           required data-bv-trigger="keyup change"
                           data-bv-notempty-message="{{trans('generic::global.required')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <input id="email" value="{{ old('email', $user->email) }}"
                           name="email" type="text" class="form-control"
                           required data-bv-trigger="keyup change"
                           data-bv-notempty-message="{{trans('generic::global.required')}}">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input id="phone" value="{{ old('phone', $user->phone) }}"
                           name="phone" type="text" class="form-control"
                           required data-bv-trigger="keyup change"
                           data-bv-notempty-message="{{trans('generic::global.required')}}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Password</label>
                <div class="col-md-9">
                    <input id="password" value=""
                           name="password" type="text" class="form-control"
                           data-bv-trigger="keyup change" placeholder="****** Type to change"
                           data-bv-notempty-message="{{trans('generic::global.required')}}">
                </div>
            </div>

            <div class="form-group" style="display: none">
                <label class="col-md-3 control-label">Group</label>
                <div class="col-md-9">
                    <select class="form-control js-tags" name="roles" >
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    @if($role->id == @$user->roles[0]->id) selected @endif
                            >{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Block</label>
                <div class="col-md-9">
                    <input type="checkbox" name="block" value="1"
                            {{old('active',$user->block)==1?'checked':'' }}/>
                </div>
            </div>


            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">Submit</button>
                        <input type="reset" class="btn default" value="Reset">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('sub_scripts')
    <script>
        $(document).ready(function () {
            @if(!empty($user->id))
            $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
            $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
            $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
            $('#link').val('');
            $('#category_id').val('');
            $('#item_id').val('');
            $('#category_id').attr('disabled', 'true');
            $('#item_id').attr('disabled', 'true');
            $('#link').attr('disabled', 'true');
                    @else
            var type = $('#type').val();
            if (type == 1) {
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', true);
                $('#category_id').val('');
                $('#item_id').val('');
                $('#category_id').attr('disabled', 'true');
                $('#item_id').attr('disabled', 'true');
                $('#link').removeAttr('disabled');
            } else if (type == 2) {
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', true);
                $('#link').val('');
                $('#item_id').val('');
                $('#item_id').attr('disabled', 'true');
                $('#link').attr('disabled', 'true');
                $('#category_id').removeAttr('disabled');

            } else if (type == 3) {

                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', true);
                $('#link').val('');
                $('#category_id').val('');
                $('#category_id').attr('disabled', 'true');
                $('#link').attr('disabled', 'true');
                $('#item_id').removeAttr('disabled');

            } else {
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
                $('#link').val('');
                $('#category_id').val('');
                $('#item_id').val('');
                $('#category_id').attr('disabled', 'true');
                $('#item_id').attr('disabled', 'true');
                $('#link').attr('disabled', 'true');
            }
            @endif
        });
        $('#type').change(function () {
            var type = $(this).val();
            if (type == 1) {
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', true);
                $('#category_id').val('');
                $('#item_id').val('');
                $('#category_id').attr('disabled', 'true');
                $('#item_id').attr('disabled', 'true');
                $('#link').removeAttr('disabled');
            } else if (type == 2) {
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', true);
                $('#link').val('');
                $('#item_id').val('');
                $('#item_id').attr('disabled', 'true');
                $('#link').attr('disabled', 'true');
                $('#category_id').removeAttr('disabled');

            } else if (type == 3) {

                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', true);
                $('#link').val('');
                $('#category_id').val('');
                $('#category_id').attr('disabled', 'true');
                $('#link').attr('disabled', 'true');
                $('#item_id').removeAttr('disabled');

            } else {
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('link', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('category_id', false);
                $('#ad_add_form').data('bootstrapValidator').enableFieldValidators('item_id', false);
                $('#link').val('');
                $('#category_id').val('');
                $('#item_id').val('');
                $('#category_id').attr('disabled', 'true');
                $('#item_id').attr('disabled', 'true');
                $('#link').attr('disabled', 'true');
            }
        });

    </script>
@endsection
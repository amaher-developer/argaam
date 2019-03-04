@extends('generic::front.layouts.master')
@section('style')

@stop
@section('content')
    <div class="sign_up_widget sign_in_page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="new_account sign_in_widget">
                        <h3>{{trans('global.update_profile')}}</h3>

                        <form role="form" method="POST" >
                            {{ csrf_field() }}
                        <input class="custom_input" type="text" name="name" value="{{$currentUser->name}}" placeholder="{{trans('global.name')}}"
                        data-bv-trigger="keyup change"
                            required data-bv-notempty-message="{{trans('generic::global.required')}}">
                        <input class="custom_input" type="text" name="phone" value="{{$user->phone}}" placeholder="{{trans('global.phone')}}"
                        data-bv-trigger="keyup change"
                            required data-bv-notempty-message="{{trans('generic::global.required')}}">
                        <input class="custom_input" type="email" name="email" value="{{$currentUser->email}}" placeholder="{{trans('global.email')}}"
                        data-bv-trigger="keyup change"
                            required data-bv-notempty-message="{{trans('generic::global.required')}}">
                        <input class="custom_input" type="password" name="password" placeholder="********" >
                        <input type="submit" class="login loginmodal-submit" value="{{trans('global.update')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
@stop

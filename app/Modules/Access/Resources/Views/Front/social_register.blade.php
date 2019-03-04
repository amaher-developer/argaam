@extends('generic::front.layouts.master')

@section('content')
    <div class="sign_up_widget">
        <div class="container">
            <div class="row">
                @if(@$social_error)
                    <div class="alert alert-danger">
                        {{ @$social_error }}
                    </div>
                @endif
                <div class="col-md-6 border_class">
                    <div class="new_account">
                        <form method="POST" action="{{ route('socialRegister') }}">
                            {{csrf_field()}}
                            <h3>{{trans('global.complete_user_data')}}</h3>
                            <input type="hidden" name="{{ $social_type }}"
                                   value="{{ $social_user->id }}">
                            <input class="custom_input" value="{{ $social_user->name }}" type="text"
                                   name="name" placeholder="{{trans('global.name')}}">
                            <input class="custom_input" value="{{ @$social_user->phone }}" type="text"
                                   name="phone" placeholder="{{trans('global.phone')}}">
                            <input class="custom_input" value="{{ $social_user->email }}" type="email"
                                   name="email" placeholder="{{trans('global.email')}} ">
                            <input class="custom_input" value="" type="password"
                                   name="password" placeholder="{{trans('global.password')}} ">
                            <input type="submit" class="login loginmodal-submit" value="{{trans('global.register')}}">
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="new_account">
                        <h3>{{trans('global.register_through')}}</h3>
                        <input type="submit" name="login" class="login loginmodal-submit facebook"
                               onclick='window.location.href = "{{route('socialLogin').'?provider=facebook'}}"'
                               value="{{trans('global.facebook')}}">
                        <input type="submit" name="login" class="login loginmodal-submit google"
                               onclick='window.location.href = "{{route('socialLogin').'?provider=google'}}"'
                               value="{{trans('global.google_plus')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


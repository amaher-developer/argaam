@extends('generic::front.layouts.master')

@section('content')
    <div class="sign_up_widget">
        <div class="container">
            <div class="row">
                <div class="col-md-6 border_class">
                    <div class="new_account">
                        <form method="POST" action="{{ route('register') }}">
                            {{csrf_field()}}
                            <h3>{{trans('global.register_now')}}</h3>
                            <input value="{{ old('name') }}" class="custom_input" type="text" name="name"
                                   placeholder="{{trans('global.name')}}">
                            <input required value="{{ old('phone') }}" class="custom_input" type="tel" minlength="8"
                                   pattern="[0-9]+"
                                   maxlength="12"
                                   name="phone"
                                   placeholder="{{trans('global.phone')}}">
                            <input value="{{ old('email') }}" class="custom_input" type="email" name="email"
                                   placeholder="{{trans('global.email')}} ">
                            <input class="custom_input" type="password" name="password"
                                   placeholder="{{trans('global.password')}}">
                            <input class="custom_input" type="password" name="password_confirmation"
                                   placeholder="{{trans('global.password_confirm')}}">
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


@extends('generic::front.layouts.master')

@section('content')
    <div class="sign_up_widget">
        <div class="container">
            <div class="row">


                <div class="col-md-6 border_class col-md-offset-3">
                    <div class="new_account">
                        <form role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <h3 class="text-center">{{trans('global.login')}}</h3>
                            <div class="form-group">
                            <label class="">Phone</label><br>
                            <input class="form-control" type="tel" name="phone" placeholder="{{trans('global.phone')}}">
                            </div>
                            <div class="form-group">
                            <label class="">Password</label>
                            <br>
                            <input class="form-control" type="password" name="password" placeholder="{{trans('global.password')}}">
                            </div>
                            <div class="form-group">
                            <div class="remember_me remember_me_sign_in">
                                <input type="checkbox" name="remember" value="1"><span class="checkbox_text">{{trans('global.remember_me')}}</span>
                                <p><a href="{{ route('password.request') }}" class="forget_password">{{trans('global.forgot_password')}}</a></p>
                            </div>
                            </div>
                            <input type="submit"  class="btn btn-default btn-lg" value="{{trans('global.enter')}}">
                        </form>
                    </div>
                </div>
                {{--<div class="col-md-6">--}}
                    {{--<div class="new_account custom_style">--}}
                        {{--<h3>{{trans('global.register_through')}}</h3>--}}
                        {{--<input type="submit" name="login" class="login loginmodal-submit facebook"--}}
                               {{--onclick='window.location.href = "{{route('socialLogin').'?provider=facebook'}}"' value="{{trans('global.facebook')}}">--}}
                        {{--<input type="submit" name="login" class="login loginmodal-submit google"--}}
                               {{--onclick='window.location.href = "{{route('socialLogin').'?provider=google'}}"' value="{{trans('global.google_plus')}}">--}}
                        {{--<div class="new_account_widget">--}}
                            {{--<p><a class="">{{trans('global.new_account')}}</a></p>--}}
                            {{--<input  onclick='window.location.href = "{{route('register')}}"' type="submit" name="login" class="login loginmodal-submit" value="{{trans('global.register_now')}}">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection

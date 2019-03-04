<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ @$mainSettings->name }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @yield('style')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ @$mainSettings->name }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        {{--                        <li><a href="{{ route('register') }}">Register</a></li>--}}
                    @else



                        <li><a>{{ "Hello ". Auth::user()->name }}</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>

                        <li>
                            @permission(['dashboard','super'])
                             <a href="{{ url('/operate') }}">Dashboard</a>
                            @endpermission</li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @foreach($categories as $category)
    <span style="padding: 10px;">@if(@request('category_id') == $category->id) {{$category->name}} @else <a href="{{route('listFrontArticles', [$category->id, $category->slug])}}">{{$category->name}}</a>@endif | </span>
    @endforeach
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ol>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ol>
        </div>
    @elseif(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(request()->session()->has('alert-' . $msg))
            <div class="alert alert-{{ $msg }}">{{ request()->session()->get('alert-' . $msg) }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
        @endif
    @endforeach
<!-- end of the header -->


    @yield('content')
    {{--@yield('footer')--}}
    @section('footer')
    @show

    <link href="{{ asset('js/app.js') }}" rel="stylesheet">

    @yield('script')
</div>

</body>
</html>
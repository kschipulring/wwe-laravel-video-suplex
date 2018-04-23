<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Video Uploader">

    <meta name="author" content="Karl Schipul">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WWE Laravel Video Uploader') }} - @yield('titlesupplment')</title>


    <?php
    $base_dir = urlencode( asset('/') );
    ?>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js?base_dir=') . $base_dir }}"></script>

    <script src="{{ asset('public/js/vue.1.0.16.js') }}"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/common.css') }}" rel="stylesheet" />

    @yield('headtag')
</head>
<body>
    @include('partials.common-navbar')

    <div id="app">        
        <nav class="navbar navbar-default navbar-static-top" style="display:none">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <?php
                /*
                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="display:none">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <!--
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                            -->
                        @else

                            <!--
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        -->
                        @endif
                    </ul>
                </div>
                */
                ?>
            </div>
        </nav>

        @yield('content')
    </div>

    @yield('endscriptfooter')
    
</body>
</html>

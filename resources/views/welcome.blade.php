<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Auth::guard()->check() || auth()->guard('instructor')->check())
                <div class="top-right links">
                    @if (auth()->guard('instructor')->check())
                        <a href="{{ url('/instructor') }}">Instructor Home</a>
                    @elseif(Auth::guard()->check())
                        <a href="{{ url('/home') }}">Home</a>
                    @endif
                </div>
                @else
                <div class="top-right links">
                    <a href="{{ route('InstructorLogin') }}">In.Login</a>
                    <a href="{{ route('InstructorRegister') }}">In.Register</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel <br>
                    @if(function_exists('it_des'))
                    <b><a href="http://phpanonymous.com/it"><img src="{{it_des('it/img/it100-100.png')}}" /></a></b>

                    @endif
                    
                </div>
                    @if(function_exists('it_des'))
                 <small style="color:#c33">A simple track to make sense</small> <br>
                  <a href="{{ url('admin') }}">Go To Admin Panel</a>

                  <p>run command : php artisan db:seed</p>
                    <p>email: test@test.com</p>
                    <p>password: 123456</p>
                    @endif
                <div class="links">
                    <br>
                    @if(function_exists('it_des'))
                    <a href="{{url('it')}}">It Tools <img src="{{it_des('it/img/it32-32.png')}}" /></a>
                    <a href="https://phpanonymous.com/it">It Documentation <img src="{{it_des('it/img/it32-32.png')}}" /></a>
                    @endif
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mitimise</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                width: 100vw;
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

            .links {
                display: flex;
                align-items: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 20px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                text-align: center;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @foreach (Config::get('app.availableLanguages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <a href="{{ route('lang.set', $lang) }}">{{$language}}</a>
                        @endif
                    @endforeach
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Mitimise
                </div>

                <div class="center links">
                    <a href="{{ route('home') }}">{{ __('Find your friends') }}</a>
                    <a href="{{ route('home') }}">{{ __('Create circles of friends') }}</a>
                    <a href="{{ route('home') }}">{{ __('Plan meetings') }}</a>
                </div>
            </div>
        </div>
    </body>
</html>

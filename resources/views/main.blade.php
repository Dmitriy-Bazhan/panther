<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panther</title>

    <!--BOOTSTRAP-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('js/jQuery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script>
        //first enter in site
        let checkLocale = window.localStorage.getItem('locale');
        if(checkLocale === undefined){
            window.localStorage.setItem('locale', 'de');
        }
        //first enter in site

        window.guard = '{{ auth()->user()->entity_type ?? 'guest'}}';
        window.locale = @auth()'{{ auth()->user()->prefs->pref_lang }}' @else window.localStorage.getItem('locale') @endauth;
        window.dashboard = '{{ request()->segment(1) ?? 'no'}}';
    </script>

</head>

<body>

<div id="app">
    <app :user="@auth {{ auth()->user() }} @else false @endauth"></app>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>

</html>

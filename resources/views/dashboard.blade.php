<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panther</title>

    <!--BOOTSTRAP-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('js/jQuery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script>
        window.guard = '{{ auth()->user()->entity_type ?? 'guest'}}';
        window.locale = '{{ auth()->user()->prefs->pref_lang }}';
        window.dashboard = '{{ request()->segment(1) ?? 'no'}}';
    </script>

</head>

<body>



<div id="dashboard">
    <dashboard
        :user="{{ auth()->user() }}"
        :data="{{ json_encode($data ?? []) }}"
    >

    </dashboard>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>

</html>

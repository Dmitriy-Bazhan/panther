<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panther</title>

    <!--BOOTSTRAP-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('js/jQuery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script>
        window.guard = '{{ auth()->user()->entity_type ?? 'guest'}}';
    </script>

</head>

<body>

<div id="app" data="@auth {{ json_encode(auth()->user()) }} @else false @endauth">
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>

</html>

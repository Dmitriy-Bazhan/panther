<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{  config('app.name') }} </title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
<br>
<br>
<div class="d-block text-center">
    <div class="d-inline-block">
        <img src="{{ asset('images/logo2.png') }}">
    </div>
    <div class="d-inline-block">
        <h3>{{  config('app.name') }}</h3>
        <p class="text-muted">{{ config('settings.phone') }}</p>
        <p class="text-muted">{{ config('settings.address') }}</p>
        <p class="text-muted">{{ config('settings.country') }}</p>
        <p class="text-muted">{{ config('settings.site_email') }}</p>
    </div>
</div>
<br>
<div class="d-block">
    <div class="d-inline-block">
        <div class="d-inline-block invoice-pdf-payment-first-block">
            {{ $contract->text }}
        </div>
    </div>
</div>
<br>
<br>
<br>
</body>
</html>

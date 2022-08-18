<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{  config('app.name') }} @lang('invoice.invoice') {{ \Carbon\Carbon::now()->format('Y-m-d H:s') }}</title>
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
<br>
<div class="d-block">
    <div class="d-inline-block">
        <div class="d-inline-block invoice-pdf-payment-first-block">
            <h3>@lang('invoice.booking')</h3>
        </div>
    </div>
    <div class="d-inline-block invoice-pdf-payment-second-block">
        <h3>@lang('invoice.client')</h3>
    </div>
</div>
<br>
<br>
<div class="d-block">
    <div class="d-inline-block">
        <div class="d-inline-block">
            <p class="text-muted">@lang('invoice.booking_start_date')</p>
            <p class="text-muted">@lang('invoice.booking_finish_date')</p>
            <p class="text-muted">@lang('invoice.regularity')</p>
            @if($payment->booking->one_time_or_regular == 'one')
                <p class="text-muted">@lang('invoice.hours')</p>
                <p class="text-muted">&nbsp;</p>
                <p class="text-muted">&nbsp;</p>
            @endif

            @if($payment->booking->one_time_or_regular == 'regular')
                <p class="text-muted">@lang('invoice.weeks')</p>
                <p class="text-muted">@lang('invoice.days')
                    @foreach($payment->booking->real_days as $day)
                        <br>
                    @endforeach
                </p>
                <p class="text-muted">@lang('invoice.hours')</p>
            @endif
        </div>

        <div class="d-inline-block invoice-pdf-payment-booking-data-block">
            <p class="text-muted">{{ $payment->booking->start_date }}</p>
            <p class="text-muted">{{ $payment->booking->finish_date }}</p>
            <p class="text-muted">{{ $payment->booking->one_time_or_regular }}</p>
            @if($payment->booking->one_time_or_regular == 'one')
                <p class="text-muted">{{ $payment->booking->hours }}</p>
                <p class="text-muted">&nbsp;</p>
                <p class="text-muted">&nbsp;</p>
            @endif

            @if($payment->booking->one_time_or_regular == 'regular')
                <p class="text-muted">{{ $payment->booking->weeks }}</p>
                <p class="text-muted">
                    @foreach($payment->booking->real_days as $day)
                        {{ __($day) }}<br>
                    @endforeach
                </p>
                <p class="text-muted">{{ $payment->booking->weeks * count(json_decode($payment->booking->days, true)) * $payment->booking->hours }}
                </p>
            @endif
        </div>


        <div class="d-inline-block invoice-pdf-payment-second-block">
            <p class="text-muted">{{ $payment->booking->client->first_name . ' ' . $payment->booking->client->last_name}}</p>
            <p class="text-muted">{{ $payment->booking->client->phone }}</p>
            <p class="text-muted">{{ $payment->booking->client->email }}</p>
            <p class="text-muted">{{ $payment->booking->client->zip_code }}</p>
            <p class="text-muted">Address</p>
            @if($payment->booking->one_time_or_regular == 'regular')
                    @foreach($payment->booking->real_days as $day)
                        <br>
                    @endforeach
            @endif
        </div>
    </div>
</div>

<div class="d-block text-center invoice-title">
    <div class="d-inline-block">
        <div class="d-inline-block invoice-pdf-payment-first-block">
            <h3>@lang('invoice.payment')</h3>
            <h3>@lang('invoice.payment_method'):</h3>
        </div>
    </div>
    <div class="d-inline-block invoice-pdf-payment-second-block">
        <h3 class="text-muted">{{ $payment->sum . ' €' }}</h3>
        <h3 class="text-muted">{{ $payment->method }}</h3>
    </div>
</div>

</body>
</html>

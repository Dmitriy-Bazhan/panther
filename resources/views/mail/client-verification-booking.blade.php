<head>
    <style>
        .logo-image {
            width: 200px;
        }
        .main-slider--subtitle {
            background-color: #ff9600;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            color: #ffffff;
            padding: 5px 15px;
            border-radius: 5px;
            display: inline-block;
        }
        table{
            width: 60%;
            margin-left: 20%;
        }
        td{
            padding: 30px;
            color: #6a6a6a;
        }
        .name {
            color: #005eaf;
            font-size: 24px;
            font-weight: 700;
        }
        .booking-info{
            color: #6a6a6a;
            font-size: 16px;
            font-weight: 700;
        }
    </style>
</head>
<body>
<table>
    <tr>
        {{--        <th><img class="logo-image" src="{{ asset('/images/logo.png') }}" alt="logo"></th>--}}
        <th><img class="logo-image" src="{{ $message->embed(asset('/images/logo.png')) }}" alt="logo"></th>
    </tr>

    <tr>
        <th class="name">@lang('mail-message.hello_dear')&nbsp;{{ $user->full_name }}</th>
    </tr>

    <tr>
        <td>{{ $template }}</td>
    </tr>

    <tr>
        <th>
            @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($nurse->entity->original_photo))
                <img class="logo-image" src="{{ $message->embed(url('storage/' . $nurse->entity->original_photo)) }}"
                     alt="logo">
            @else
                <img class="logo-image" src="{{ $message->embed(asset('/images/no-photo.jpg')) }}" alt="logo">
            @endif

        </th>
    </tr>

    <tr>
        <th class="name">{{ $nurse->first_name . ' '  . $nurse->last_name}}</th>
    </tr>

    <tr>
        <th class="booking-info">{{ 'Sum: ' . $booking->total . ' €  Start date: '  . $booking->start_date . ' ' . __('site.' . $booking->one_time_or_regular)}}</th>
    </tr>

    <tr>
        <th>
            <a href="{{ $url }}">
                <button class="main-slider--subtitle">@lang('mail-message.client_verify_booking')</button>
            </a>
        </th>
    </tr>
</table>
</body>


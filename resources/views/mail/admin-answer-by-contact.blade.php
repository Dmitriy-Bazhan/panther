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

        table {
            width: 60%;
            margin-left: 20%;
        }

        td {
            padding: 30px;
            color: #6a6a6a;
        }

        .name {
            color: #005eaf;
            font-size: 24px;
            font-weight: 700;
        }

        .password {
            color: #005eaf;
            font-size: 18px;
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
        <th class="name">@lang('mail-message.hello_dear')&nbsp;{{ $contact->name }}</th>
    </tr>


    <tr>
        <td>{{ $template }}</td>
    </tr>

    <tr>
        <th class="password">
            {{ $answer }}
        </th>
    </tr>

    <tr>
        <th>
            <a href="{{ $url }}">
                <button class="main-slider--subtitle">{{ \Illuminate\Support\Facades\Config::get('app.name') }}</button>
            </a>
        </th>
    </tr>
</table>
</body>


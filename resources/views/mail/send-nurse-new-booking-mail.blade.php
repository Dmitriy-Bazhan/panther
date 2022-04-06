<head>
    <style>
        .link-button-row {
            position: relative;
            left: 45%;
        }
        .link-button {
            background: forestgreen;
            border: solid 1px green;
            color: white;
            font-size: 14px;
            font-weight: 700;
            border-radius: 5px;
            padding: 5px 10px 5px 10px;
        }
        .text-wrapper {
            position: relative;
            left: 20%;
            width: 60%;
            word-wrap: break-word;
            border: solid 1px #55ff79;
            background: #86f086;
            padding: 15px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 15px;
            margin: 10px;
        }
        .mail-title {
            position: relative;
            left: 30%;
            font-size: 18px;
            font-weight: 700;
            color: red;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="mail-title">
        @lang('mail-message.hello_dear')&nbsp;{{ ' ' . $nurse->first_name . ' '  . $nurse->last_name }}
    </div>
    <div class="text-wrapper">
        @lang('mail-message.you_take_new_booking from')&nbsp;{{ ' ' . $client->first_name . ' '  . $client->last_name }}
    </div>
    <div class="link-button-row">
        <a href="{{ $url }}">
            <button class="link-button">@lang('mail-message.go_to_my_bookings')</button>
        </a>
    </div>
</div>
</body>

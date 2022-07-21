<head>
    <style>
        .link-button-row {
            margin: 25px 0 0 40%;
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

        .logo {
            height: 100px;
        }

        .logo-image {
            position: relative;
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
<div>
    <div class="logo">
        <img class="logo-image" src="{{ $message->embed(asset('/images/logo.png')) }}" alt="logo">
    </div>
    <div class="mail-title">
        @lang('mail-message.hello_dear')&nbsp;{{ ' ' . $client->first_name . ' '  . $client->last_name }}
    </div>
    <div class="text-wrapper">
        @lang('mail-message.booking_verification_text_part_one')
        &nbsp;{{ ' ' . $nurse->first_name . ' '  . $nurse->last_name . ' ' }}
        @lang('mail-message.booking_verification_text_part_two')
    </div>
    <div class="logo">
        @if(file_exists(url('storage/' . $nurse->entity->original_photo)))
            <img class="logo-image" src="{{ $message->embed(url('storage/' . $nurse->entity->original_photo)) }}"
                 alt="logo">
        @else
            <img class="logo-image" src="{{ $message->embed(asset('/images/no-photo.jpg')) }}" alt="logo">
        @endif
    </div>
    <div class="link-button-row">
        <a href="{{ $url }}">
            <button class="link-button">@lang('mail-message.client_verify_booking')</button>
        </a>
    </div>
</div>
</body>

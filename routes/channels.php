<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function () {
    return true;
});

Broadcast::channel('admin', function ($user) {
    if ($user->is_admin) {
        return true;
    }
    return false;
});

Broadcast::channel('client-between-nurse.{nurse_id}.{client_id}', function ($user, $nurse_id, $client_id) {
    if ($user->is_client) {
        return true;
    }

    if ($user->is_nurse) {
        return true;
    }

    return false;
});

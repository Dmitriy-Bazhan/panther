<?php


namespace App\CronJob;


use App\Http\Repositories\ChatRepository;
use App\Models\Chat;
use Carbon\Carbon;

class RemoveTaskAfterThirtyDays
{
    public function __invoke()
    {
            $day = Carbon::now()->format('Y-m-d');
            Chat::where('status', 'deleted')->where('delete_date', $day)
                ->chunk(5, function ($chats){
                    $chatRepo = new ChatRepository();

                    foreach ($chats as $chat){
                        $chatRepo->removeChatAndAllThatRelationWithHim($chat);
                    }
                });
    }
}

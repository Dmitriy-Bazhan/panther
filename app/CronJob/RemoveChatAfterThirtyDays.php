<?php


namespace App\CronJob;


use App\Http\Repositories\ChatRepository;
use App\Models\Chat;
use Carbon\Carbon;

class RemoveChatAfterThirtyDays
{
    public function __invoke()
    {
        $chatRepo = new ChatRepository();

        $day = Carbon::now()->format('Y-m-d');
        Chat::where('status', 'deleted')->where('delete_date', $day)
            ->chunk(5, function ($chats) use ($chatRepo) {
                foreach ($chats as $chat) {
                    $chatRepo->removeChatAndAllThatRelationWithHim($chat);
                }
            });
    }
}

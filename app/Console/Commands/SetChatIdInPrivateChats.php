<?php

namespace App\Console\Commands;

use App\Models\Chat;
use App\Models\PrivateChat;
use Illuminate\Console\Command;

class SetChatIdInPrivateChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:set-chat-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $chatsUsersIds = Chat::select('id','nurse_user_id', 'client_user_id')->get()->toArray();
        foreach ($chatsUsersIds as $item){
            PrivateChat::where('nurse_user_id', $item['nurse_user_id'])
                ->where('client_user_id',  $item['client_user_id'])
                ->update([
                    'chat_id' => $item['id']
                ]);
        }

        return 0;
    }
}

<?php

namespace App\Events\PrivateChat;

use App\Mail\MailThatYouHaveNewMessagesMail;
use App\Models\PrivateChat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ClientNurseSentMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function broadcastOn()
    {
        $this->sendEmailAboutNewMessages($this->result);

        return new PrivateChannel('client-between-nurse.' . $this->result->nurse_user_id . '.' .$this->result->client_user_id);
    }

    public function broadcastWith()
    {
        return [
            'result' => $this->result,
            'nurse_count_unread_message' => PrivateChat::where('nurse_user_id', $this->result->nurse_user_id)->where('status', 'unread')->count(),
            'client_count_unread_message' => PrivateChat::where('client_user_id', $this->result->client_user_id)->where('status', 'unread')->count(),
        ];
    }

    private function sendEmailAboutNewMessages($result){
        $client = User::where('id', $result->client_user_id)->without('entity', 'prefs')->first();
        $nurse = User::where('id', $result->nurse_user_id)->without('entity', 'prefs')->first();
        $regularity = config('settings.regularity_of_email_about_new_messages');

        $now = Carbon::now();
        $sendEmailToClient = false;
        if(!is_null($client->last_email_about_new_messages)){
            $different = $now->diffInHours($client->last_email_about_new_messages);
            if($different > $regularity){
                $sendEmailToClient = true;
            }
        }else{
            $sendEmailToClient = true;
        }

        $sendEmailToNurse = false;
        if(!is_null($nurse->last_email_about_new_messages)){
            $different = $now->diffInHours($nurse->last_email_about_new_messages);
            if($different > $regularity){
                $sendEmailToNurse = true;
            }
        }else{
            $sendEmailToNurse = true;
        }

        if($sendEmailToClient){
            $client->last_email_about_new_messages = $now;
            $client->save();

            if (config('mail_use_queue')) {
                Mail::mailer('smtp')->to($client->email)
                    ->queue(new MailThatYouHaveNewMessagesMail($client));
            } else {
                Mail::mailer('smtp')->to($client->email)
                    ->send(new MailThatYouHaveNewMessagesMail($client));
            }
        }

        if($sendEmailToNurse){
            $nurse->last_email_about_new_messages = $now;
            $nurse->save();
            if (config('mail_use_queue')) {
                Mail::mailer('smtp')->to($nurse->email)
                    ->queue(new MailThatYouHaveNewMessagesMail($nurse));
            } else {
                Mail::mailer('smtp')->to($nurse->email)
                    ->send(new MailThatYouHaveNewMessagesMail($nurse));
            }
        }

        return true;
    }
}

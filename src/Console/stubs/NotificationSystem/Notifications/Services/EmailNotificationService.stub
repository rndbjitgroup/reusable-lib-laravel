<?php 

namespace App\Services\Notifications;

use App\Models\User;
use App\Notifications\SendDatabaseNotification;
use App\Notifications\SendEmailNotification;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class EmailNotificationService 
{
    use RespondsWithHttpStatus;
    
    /**
     * Validate category data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function notify($request)
    {
        $user = User::find(1);
        $data = [
            'name' => '#001 Bill',
            'body' => 'You have received a new bill.', 
            'amount' => '$500',
            'offer' => url('/'),
            'bill_id' => 10001
        ];
        //$user = $user->notify(new SendEmailNotification($data));
        Notification::send($user, new SendEmailNotification($data)); 
        return $this->success('Email Notification is sent successfully!');
    }
 
 
 
}
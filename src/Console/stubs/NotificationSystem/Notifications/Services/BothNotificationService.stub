<?php 

namespace App\Services\Notifications;

use App\Models\User;
use App\Notifications\SendBothNotification;
use App\Notifications\SendDatabaseNotification;
use App\Notifications\SendEmailNotification;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class BothNotificationService 
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
            'name' => '#003 Bill',
            'body' => 'You have received a new bill.', 
            'amount' => '$800',
            'offer' => url('/'),
            'bill_id' => 10003
        ]; 
        Notification::send($user, new SendBothNotification($data)); 
        return $this->success('Both Notification is sent successfully!');
    }
 
 
}
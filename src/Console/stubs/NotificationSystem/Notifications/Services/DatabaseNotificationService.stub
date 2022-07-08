<?php 

namespace App\Services\Notifications;

use App\Models\User;
use App\Notifications\SendDatabaseNotification;
use App\Notifications\SendEmailNotification;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class DatabaseNotificationService 
{
    use RespondsWithHttpStatus;

    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    public function markNotification($request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }

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
            'name' => '#002 Bill',
            'body' => 'You have received a new bill.', 
            'amount' => '$600',
            'offer' => url('/'),
            'bill_id' => 10002
        ];
        //$user = $user->notify(new SendEmailNotification($data));
        Notification::send($user, new SendDatabaseNotification($data)); 
        return $this->success('Database Notification is sent successfully!');
    }
 
 
 
}
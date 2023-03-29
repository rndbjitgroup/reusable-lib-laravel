<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Services\Notifications\EmailNotificationService;
use Illuminate\Http\Request;

class EmailNotificationController extends Controller
{
    protected $emailNotificationService;
    
    public function __construct(EmailNotificationService $emailNotificationService)
    {
        $this->emailNotificationService = $emailNotificationService;
    }

    /**
     * @OA\Get(
     *      path="/notifications/email",
     *      operationId="sendEmailNotification",
     *      tags={"Notifications"},
     *      summary="Send Email Notification",
     *      description="Send Email Notification", 
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthenticated."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This action is unauthorized."),
     *          )
     *      ), 
     * )
     */
    public function notify(Request $request)
    {
        return $this->emailNotificationService->notify($request);
    }

    
}

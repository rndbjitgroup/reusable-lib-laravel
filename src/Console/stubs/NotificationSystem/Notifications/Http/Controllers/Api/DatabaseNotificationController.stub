<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Services\Notifications\DatabaseNotificationService;
use Illuminate\Http\Request;

class DatabaseNotificationController extends Controller
{
    protected $databaseNotificationService;
    
    public function __construct(DatabaseNotificationService $databaseNotificationService)
    {
        $this->databaseNotificationService = $databaseNotificationService;
    }

    public function index(Request $request)
    {
        return $this->databaseNotificationService->index($request); 
    }

    public function markNotification(Request $request)
    {
        return $this->databaseNotificationService->markNotification($request); 
    }

    /**
     * @OA\Get(
     *      path="/notifications/database",
     *      operationId="sendDatabaseNotification",
     *      tags={"Notifications"},
     *      summary="Send Database Notification",
     *      description="Send Database Notification", 
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
        return $this->databaseNotificationService->notify($request);
    }

    

}

<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Services\Notifications\BothNotificationService;
use Illuminate\Http\Request;

class BothNotificationController extends Controller
{
    protected $bothNotificationService;
    
    public function __construct(BothNotificationService $bothNotificationService)
    {
        $this->bothNotificationService = $bothNotificationService;
    }

    /**
     * @OA\Get(
     *      path="/notifications/both",
     *      operationId="sendNotificationsBoth",
     *      tags={"Notifications"},
     *      summary="Send Both Notifications",
     *      description="Send Both Notifications", 
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
        return $this->bothNotificationService->notify($request);
    }


    
    
}

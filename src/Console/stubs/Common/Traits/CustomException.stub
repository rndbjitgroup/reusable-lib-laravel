<?php 

namespace App\Traits\Common;

use App\Exceptions\Custom\AuthenticationException as CustomAuthenticationException;
use App\Exceptions\Custom\AuthorizationException as CustomAuthorizationException;
use App\Exceptions\Custom\ErrorException as CustomErrorException;
use App\Exceptions\Custom\HttpException as CustomHttpException;
use App\Exceptions\Custom\MethodNotAllowedHttpException as CustomMethodNotAllowedHttpException;
use App\Exceptions\Custom\ModelNotFoundException as CustomModelNotFoundException;
use App\Exceptions\Custom\NotDefinedException;
use App\Exceptions\Custom\NotFoundHttpException as CustomNotFoundHttpException; 
use App\Exceptions\Custom\QueryException as CustomQueryException;
use App\Exceptions\Custom\RouteNotFoundException as CustomRouteNotFoundException;
use App\Exceptions\Custom\SesException as CustomSesException;
use App\Exceptions\Custom\UnauthorizedException as CustomUnauthorizedException;
use App\Exceptions\Custom\ValidationException as CustomValidationException;
use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException; 
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

trait CustomException 
{
    public function render($request, Throwable $e)
    {
        return $this->handleApiExceptions($request, $e);
    }

    protected function handleApiExceptions($request, $e)
    {
        //dd($e->getMessage(), $e); 
        Log::error($e->getMessage());
        Log::error($e->getCode());
        Log::error($e->getTraceAsString());
        Log::error($e);

        if ($e instanceof RouteNotFoundException) {
            return (new CustomRouteNotFoundException($e))->render(); 
        } 

        if ($e instanceof AuthenticationException) {
            return (new CustomAuthenticationException($e))->render(); 
        } 

        if ($e instanceof AuthorizationException) {
            return (new CustomAuthorizationException($e))->render(); 
        } 

        if($e instanceof ModelNotFoundException) {
            return (new CustomModelNotFoundException($e))->render();
        }

        if ($e instanceof ValidationException) {
            return (new CustomValidationException($e))->render();
        }

        if ($e instanceof QueryException) { 
            return (new CustomQueryException($e))->render();
        }

        if ($e instanceof NotFoundHttpException) {
            return (new CustomNotFoundHttpException($e))->render(); 
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return (new CustomMethodNotAllowedHttpException($e))->render(); 
        }

        if ($e instanceof UnauthorizedException) {
            return (new CustomUnauthorizedException($e))->render(); 
        }

        if($e instanceof ErrorException) {
            return (new CustomErrorException($e))->render(); 
        }

        // if ($e instanceof HttpException) { 
        //     return (new CustomHttpException($e))->render(); 
        // }

        // if($e instanceof SesException) {
        //     return (new CustomSesException($e))->render(); 
        // } 

        //error not defined above
        if ($e) {
            return (new NotDefinedException($e))->render(); 
        }
        return parent::render($request, $e);
    }
}
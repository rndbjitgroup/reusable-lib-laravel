<?php 

namespace App\Exceptions\Custom;

use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class RouteNotFoundException
{
    use RespondsWithHttpStatus;

    /**
     * @var $exception;
     */
    protected $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function render()
    { 
        return $this->failure($this->exception->getMessage(), Response::HTTP_UNAUTHORIZED);
    }

} 
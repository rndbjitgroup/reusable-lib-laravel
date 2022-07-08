<?php 

namespace App\Exceptions\Custom;

use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class NotDefinedException
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
        $response['message'] = $this->exception->getMessage();
        if (config('app.debug')) {
            $response['trace'] = $this->exception->getTrace();
            $response['code'] = $this->exception->getCode();
        }
        return $this->failure($response, Response::HTTP_GONE);
    }

} 
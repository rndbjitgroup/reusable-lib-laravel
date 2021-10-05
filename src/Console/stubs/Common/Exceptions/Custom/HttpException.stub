<?php 

namespace App\Exceptions\Custom;

use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class HttpException
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
        $message = !empty($this->exception->getMessage()) ? $this->exception->getMessage() : __('auth.unauthorized');
        return $this->failure($message, Response::HTTP_FORBIDDEN);
    }

} 
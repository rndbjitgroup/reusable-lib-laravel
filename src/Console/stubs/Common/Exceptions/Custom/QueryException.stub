<?php 

namespace App\Exceptions\Custom;

use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class QueryException
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
        $message = App::environment('local', 'staging') ? $this->exception->getMessage() :  __('messages.queryException');
        return $this->failure($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

} 
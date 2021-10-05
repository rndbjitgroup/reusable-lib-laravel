<?php 

namespace App\Exceptions\Custom;

use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class ModelNotFoundException
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
        return $this->failure(trans('messages.notFoundId'), Response::HTTP_NOT_FOUND);
    }

} 
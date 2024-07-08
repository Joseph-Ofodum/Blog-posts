<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\HttpResponses;

class Handler extends ExceptionHandler
{
    use HttpResponses;

    public function register()
    {
        $this->renderable(function (ModelNotFoundException $e, $request) {

            return $this->error(null, 'Blog does not exist', 404);
            
        });

    }

}

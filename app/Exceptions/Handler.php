<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Exception $e, Request $request) {
            if($request->is('api/*')) {
                return response()->json([
                    'status_code' => 403,
                    'message' => __($e->getMessage()), 
                ], 403, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}

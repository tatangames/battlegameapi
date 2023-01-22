<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // SOBREESCRIBIENDO MENSAJE DE NO AUTENTIFICADO

    /*protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'No autentificado.'], 401);
        }

        //return redirect()->guest('login');
    }*/

    public function render($request, Throwable $exception){

        if($exception instanceof ModelNotFoundException){
            return response()->json(["success" => false, "error" => "Error modelo no encontrado"], 400);
        }

        if($exception instanceof RouteNotFoundException){
            return response()->json(["success" => false, "error" => "La ruta no se encontro"], 401);
        }

        if($exception instanceof AuthenticationException){
            return response()->json(["success" => false, "error" => "No tiene permisos para acceder a esta ruta"], 401);
        }

        return parent::render($request, $exception);
    }

}

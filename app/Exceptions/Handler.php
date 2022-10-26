<?php

namespace App\Exceptions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {
        //
    }

    public function report(Throwable $e) {
        if (app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }

    public function shouldReport(Throwable $e) {
        if (App::environment('local')) {
            return false;
        }

        return parent::shouldReport($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return Application|RedirectResponse|Response|Redirector
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception) {
        if ($exception instanceof NotFoundHttpException) {
            if (!isset($urlVars[3]) || !isset($urlVars[4])) {
                return redirect('/' . app()->getLocale() . '/');
            }
            $urlVars = explode('/', url()->current());
            $locale = $urlVars[3];
            $lastPart = $urlVars[4];
            if (app()->getLocale() !== $locale) {
                return redirect('/' . app()->getLocale() . '/' . $lastPart);
            }
        }

        return parent::render($request, $exception);
    }
}

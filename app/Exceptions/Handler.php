<?php

namespace App\Exceptions;

use Exception;
use OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {   
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if(is_a($e, 'Illuminate\Session\TokenMismatchException')) {
            Session::regenerateToken();

            return Redirect::to('/');
        }

        if (\App::runningInConsole()) {
            return $this->renderForConsole((new ConsoleOutput('VERBOSITY_DEBUG')), $e);
        }

        return parent::render($request, $e);
    }
}

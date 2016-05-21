<?php

namespace App\Exceptions;

use Exception;
use OutputInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Session\TokenMismatchException;
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
        if ($e instanceof TokenMismatchException){
            //redirect to form an example of how I handle mine
            return redirect('/')
                ->withErrors(["You have been idle for too long. Please try again."]);
        }


        if (\App::runningInConsole()) {
            return $this->renderForConsole((new ConsoleOutput('VERBOSITY_DEBUG')), $e);
        }

        return parent::render($request, $e);
    }
}

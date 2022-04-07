<?php
namespace Xetaravel\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Handler extends ExceptionHandler
{

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

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

        // Manage 419 csrf token expiration error
        $this->renderable(function (\Exception $e) {
            if ($e->getPrevious() instanceof TokenMismatchException) {
                return back()->with('danger', 'You made too much time to validate the form ! Time to take a coffee !');
            };
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Ultraware\Roles\Exceptions\RoleDeniedException ||
            $exception instanceof \Ultraware\Roles\Exceptions\PermissionDeniedException ||
            $exception instanceof \Ultraware\Roles\Exceptions\LevelDeniedException) {
            //If the user is banished, redirect him to the banished page.
            if (Auth::check() && Auth::user()->hasRole('banished')) {
                return redirect()
                    ->route('page.banished');
            }

            return redirect()
                ->route('page.index')
                ->with('danger', 'You don\'t have the permission to view this page.');
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->shouldReturnJson($request, $exception)
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()
                ->guest($exception->redirectTo() ?? route('users.auth.login'))
                ->with('danger', 'You don\'t have the permission to view this page.');
    }
}

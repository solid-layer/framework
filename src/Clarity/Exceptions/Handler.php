<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 */
namespace Clarity\Exceptions;

use Exception;
use ErrorException;
use Symfony\Component\Debug\ExceptionHandler;
use Monolog\ErrorHandler as MonologErrorHandler;
use Symfony\Component\Debug\Exception\FlattenException;

/**
 * The main exception handler.
 */
class Handler extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Handles fatal error, based on the lists.
     *
     * @return void
     */
    public function handleFatalError()
    {
        $error = error_get_last();

        if ($error && $error['type'] &= E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR) {
            $this->handleError(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );
        }
    }

    /**
     * Creates an error exception.
     *
     * @param int    $num     error type e.g(E_PARSE | E_ERROR ...)
     * @param string $str     error message
     * @param string $file    the file affected by the error
     * @param int    $line    on what line affects
     * @param string $context the context
     * @return void
     */
    public function handleError($num, $str, $file, $line, $context = null)
    {
        $e = new ErrorException($str, 0, $num, $file, $line);

        $this->handleExceptionError(
            FlattenException::create($e)
        );
    }

    /**
     * Print outs a simple but useful debugging ui.
     *
     * @param $e
     * @return void
     */
    public function handleExceptionError($e)
    {
        $this->render($e);
    }

    /**
     * Render the exception.
     *
     * @param  mixed $e
     * @param  int   $status_code
     * @return mixed
     */
    public function render($e, $status_code = null)
    {
        if (is_cli()) {
            dd([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return;
        }

        $content = (new ExceptionHandler(config()->app->debug))->getHtml($e);

        $response = di()->get('response');

        if (method_exists($e, 'getStatusCode')) {
            $response->setStatusCode($e->getStatusCode());
        }

        # here, if the $status_code is not empty
        # that means we should over-ride the current status code
        # using the provided one
        if ($status_code) {
            $response->setStatusCode($status_code);
        }

        $response->setContent($content);

        return $response->send();
    }

    /**
     * Processes the error, fatal and exceptions.
     *
     * @return void
     */
    protected function report()
    {
        # let monolog handle the logging in the errors,
        # unless you want it to, you can refer to method
        # handleExceptionError()
        if (di()->has('log')) {
            MonologErrorHandler::register(di()->get('log'));
        }

        # register all the the loggers we have
        register_shutdown_function([$this, 'handleFatalError']);
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleExceptionError']);
    }
}

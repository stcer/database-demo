<?php
#ErrorHandler.php created by stcer@jz at 2024/10/11
namespace demo;

use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Log\LogManager;
use Throwable;

class ErrorHandler implements ExceptionHandlerContract
{
    protected $container;
    public function __construct($container)
    {
        $this->container = $container;
    }
    public function report(Throwable $e)
    {
        /** @var LogManager $log */
        $log = $this->container->make('log');
        $log->error($e->getMessage());
    }

    public function shouldReport(Throwable $e)
    {
        return true;
    }

    public function render($request, Throwable $e)
    {
        echo "Error:";
        echo $e->getMessage();
        echo "\n";
    }

    public function renderForConsole($output, Throwable $e)
    {
        echo "Error:";
        echo $e->getMessage();
        echo "\n";
    }
}

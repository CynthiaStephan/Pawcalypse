<?php 

require_once dirname(__DIR__).'/vendor/autoload.php';

function GenerateErrorDev($e)  {
    $whoops = new \Whoops\Run;
    $whoops->allowQuit(false);
    $whoops->writeToOutput(false);
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $html = $whoops->handleException($e);
    echo $html;
}
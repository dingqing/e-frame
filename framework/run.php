<?php

use Framework\Handles\ErrorHandle;
use Framework\Handles\EnvHandle;
use Framework\Handles\RouterHandle;
use Framework\Handles\ConfigHandle;
use Framework\Handles\LogHandle;
use Framework\Handles\NosqlHandle;
use Framework\Exceptions\CoreHttpException;
use Framework\Request;
use Framework\Response;

include __DIR__ . '/App.php';

try {
    $app = new Framework\App(dirname(__DIR__) . DIRECTORY_SEPARATOR, function () {
        return require(__DIR__ . '/Load.php');
    });

    $app->load(function () {
        // business configs
        return new EnvHandle();
    });

    $app->load(function () {
        // framework configs
        return new ConfigHandle();
    });

    $app->load(function () {
        return new LogHandle();
    });

    $app->load(function () {
        return new ErrorHandle();
    });

    $app->load(function () {
        return new NosqlHandle();
    });

    $app->load(function () {
        return new RouterHandle();
    });

    /**
     * Start
     */
    $app->run(function () use ($app) {
        return new Request($app);
    });

    $app->response(function ($app) {
        return new Response($app);
    });

} catch (CoreHttpException $e) {
    $e->reponse();
}

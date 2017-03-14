<?php

namespace App\Bootstrap;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;

class ConfigureLogging extends BaseConfigureLogging
{
    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureSingleHandler(Application $app, Writer $log)
    {
        if ($this->isApiCall($app['request'])) {
            $log->useFiles($app->storagePath().'/logs/api.log');
        } else {
            $log->useFiles($app->storagePath().'/logs/laravel.log');
        }

        // Add user name and IP
        $log->getMonolog()->pushProcessor(function ($record) {
            $record['extra']['user'] = \Auth::user() ? \Auth::user()->username : 'anonymous';
            $record['extra']['ip'] = \Request::getClientIp();
            return $record;
        });
    }

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return starts_with($request->getRequestUri(), '/api/') !== false;
    }
}

<?php

namespace App\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log {
    private static ?Logger $logger = null;

    private static function get() : Logger {
        // Singleton
        if(!self::$logger)
        {
            self::$logger = new Logger('tecnofit-app');

            self::$logger->pushHandler(
                new StreamHandler(__DIR__.'/../../logs/tecnofit-app.log', Logger::DEBUG)
            );

            self::$logger->pushHandler(
                new StreamHandler('php://stdout', Logger::DEBUG)
            );
        }

        return self::$logger;
    }

    // Registers info level logs
    public static function info(string $message, array $data)
    {
        self::get()?->info($message, $data);
    }

    public static function error(string $message, array $data)
    {
        self::get()?->error($message, $data);
    }
}
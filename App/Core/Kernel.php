<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Helpers\Config;
use Dotenv\Dotenv;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Kernel
{
    private static Logger $logger;
    private static Config $config;
    private static Container $container;
    private static Router $router;
    private static ServerRequestInterface $request;
    private static ResponseInterface $response;

    public static function start(array $config) :void
    {
        static::loadEnv();
        static::setLogger();
        static::setConfig($config);
        static::setDependencies();
        static::setRoutes();
        static::boot();
    }

    private static function loadEnv() :void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();
    }

    private static function setLogger() :void
    {
        $log = new Logger('app');
        $log->pushHandler(
            new StreamHandler(
                __DIR__ . '/../../Logs/app.log',
                Logger::WARNING
            )
        );

        static::$logger = $log;
    }

    private static function setConfig(array $config) :void
    {
        static::$config = new Config($config);
    }

    private static function setDependencies() :void
    {
        static::$container = new Container();

        $classes = Config::get('always_load');
        foreach ($classes as $class => $args) {
            $dep = static::$container->add($class);
            foreach ($args as $arg) {
                $dep->addArgument($arg);
            }
        }

        foreach(Config::get('service_providers') as $serviceProvider)
        {
            static::$container->addServiceProvider($serviceProvider);
        }
    }

    private static function setRoutes() :void
    {
        $strategy = (new ApplicationStrategy())->setContainer(static::$container);
        static::$router = (new Router())->setStrategy($strategy);

        foreach (Config::get('routes') as $route) {
            foreach ($route['http_methods'] as $method) {
                static::$router->map(
                    $method,
                    $route['uri_pattern'],
                    $route['action']
                );
            }
        }
    }

    private static function boot() :void
    {
        static::$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        static::$response = static::$router->dispatch(static::$request);

        (new SapiEmitter())->emit(static::$response);
    }
}
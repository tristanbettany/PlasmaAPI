<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Database\Connection;
use App\Core\Helpers\Config;
use Dotenv\Dotenv;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Application;

final class Kernel
{
    private static Logger $logger;
    private static Config $config;
    private static Container $container;
    private static Router $router;
    private static ServerRequestInterface $request;
    private static ResponseInterface $response;

    public static function start(
        array $config,
        bool $cli = false
    ) :void {
        static::loadEnv();
        static::setLogger();
        static::setConfig($config);
        static::setDependencies();
        static::setDb();

        if ($cli === false) {
            static::setRoutes();
            static::boot();
        } else {
            static::bootCli();
        }
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

    private static function setDb() :void
    {
        try{
            new Connection();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private static function setRoutes() :void
    {
        $strategy = (new ApplicationStrategy())->setContainer(static::$container);
        static::$router = (new Router())->setStrategy($strategy);

        foreach (Config::get('routes') as $route) {
            foreach ($route['http_methods'] as $method) {
                $middlewares = [];
                foreach($route['middleware'] as $middleware) {
                    $middlewares[] = new $middleware;
                }

                static::$router->map(
                    $method,
                    $route['uri_pattern'],
                    $route['action']
                )->middlewares($middlewares);
            }
        }
    }

    private static function boot() :void
    {
        static::$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        static::$response = static::$router->dispatch(static::$request);

        (new SapiEmitter())->emit(static::$response);
    }

    private static function bootCli() :void
    {
        $application = new Application();
        foreach(Config::get('commands') as $command) {
            $application->add(new $command);
        }

        $application->run();
    }
}
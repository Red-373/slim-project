<?php
declare(strict_types=1);

use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouterInterface;
use Infrastructure\App\Logger\LoggerFactory;
use Infrastructure\Framework\Http\ApplicationFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\JsonErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Pipeline\MiddlewareResolverFactory;
use Infrastructure\Framework\Http\Router\AuraRouterFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,
            RouterInterface::class => AuraRouterFactory::class,
            MiddlewareResolver::class => MiddlewareResolverFactory::class,
            ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,
            ErrorResponseGenerator::class => JsonErrorResponseGeneratorFactory::class,
            Psr\Log\LoggerInterface::class => LoggerFactory::class,
            ErrorResponseGeneratorInterface::class => JsonErrorResponseGeneratorFactory::class,
            /*ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                return new ErrorHandlerMiddleware(
                    $container->get(ErrorResponseGenerator::class)
                );
            },*/

        ],
    ],
    'debug' => false,
    'config_cache_enabled' => true,
];
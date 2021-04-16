<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\OAuthAction;
use App\Http\Action\User\LogoutAction;
use App\Http\Action\User\LogoutAllAction;
use App\Http\Action\V1\Category\CategoryAction;
use App\Http\Action\V1\Category\CategoryAddAction;
use App\Http\Action\V1\Category\CategoryAllAction;
use App\Http\Action\V1\Category\CategoryAttachProductAction;
use App\Http\Action\V1\Category\CategoryDeleteAction;
use App\Http\Action\V1\Category\CategoryDetachProductAction;
use App\Http\Action\V1\Category\CategoryFindAction;
use App\Http\Action\V1\Category\CategoryUpdateAction;
use App\Http\Action\V1\Product\ProductAction;
use App\Http\Action\V1\Product\ProductAddAction;
use App\Http\Action\V1\Product\ProductAttachTagAction;
use App\Http\Action\V1\Tag\TagAction;
use App\Http\Action\V1\Tag\TagAddAction;
use App\Http\Action\V1\Tag\TagAttachProductAction;
use App\Http\Middleware\OAuth\OAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
    $app->post('/oauth', OAuthAction::class);

    $app->group('/v1/user', function (RouteCollectorProxy $group) {
        $group->post('/logout', LogoutAction::class);
        $group->post('/logout/all', LogoutAllAction::class);
    })->add(OAuthMiddleware::class);

    $app->group('/v1', function (RouteCollectorProxy $group) {
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('', CategoryAction::class);
            $group->get('/all', CategoryAllAction::class);
            $group->get('/find', CategoryFindAction::class);
            $group->post('/add', CategoryAddAction::class);
            $group->put('/update', CategoryUpdateAction::class);
            $group->post('/attach/products', CategoryAttachProductAction::class);
            $group->post('/detach/products', CategoryDetachProductAction::class);
            $group->delete('/delete', CategoryDeleteAction::class);
        });

        $group->group('/products', function (RouteCollectorProxy $group) {
            $group->post('/add', ProductAddAction::class);
            $group->post('/attach/tags', ProductAttachTagAction::class);
            $group->get('', ProductAction::class);
        });

        $group->group('/tags', function (RouteCollectorProxy $group) {
            $group->post('/add', TagAddAction::class);
            $group->post('/attach/products', TagAttachProductAction::class);
            $group->get('', TagAction::class);
        });
    })->add(OAuthMiddleware::class);
};

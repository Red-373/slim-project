<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\V1\Category\CategoryAction;
use App\Http\Action\V1\Category\CategoryAddAction;
use App\Http\Action\V1\Category\CategoryAllAction;
use App\Http\Action\V1\Category\CategoryAttachProductAction;
use App\Http\Action\V1\Category\CategoryDetachProductAction;
use App\Http\Action\V1\Category\CategoryFindAction;
use App\Http\Action\V1\Category\CategoryUpdateAction;
use App\Http\Action\V1\Product\ProductAction;
use App\Http\Action\V1\Product\ProductAddAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
    $app->group('/v1', function (RouteCollectorProxy $group) {
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('', CategoryAction::class);
            $group->get('/all', CategoryAllAction::class);
            $group->get('/find', CategoryFindAction::class);
            $group->post('/add', CategoryAddAction::class);
            $group->put('/update', CategoryUpdateAction::class);
            $group->post('/attach/products', CategoryAttachProductAction::class);
            $group->post('/detach/products', CategoryDetachProductAction::class);
        });

        $group->group('/products', function (RouteCollectorProxy $group) {
            $group->post('/add', ProductAddAction::class);
            $group->get('', ProductAction::class);
        });


    });
};

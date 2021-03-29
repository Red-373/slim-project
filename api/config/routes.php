<?php
declare(strict_types=1);

use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use App\Http\Action\Blog\ShowAction;
use App\Http\Action\CabinetAction;
use App\Http\Action\HelloAction;
use Framework\Http\Application;

/** @var Application $app */

$app->get('home', '/', HelloAction::class);
$app->get('about', '/about', AboutAction::class);
$app->get('cabinet', '/cabinet', CabinetAction::class);
$app->get('blog', '/blog', IndexAction::class);
$app->get('blog_page', '/blog/page/{page}', IndexAction::class, ['tokens' => ['page' => '\d+']]);
$app->get('blog_show', '/blog/{id}', ShowAction::class, ['tokens' => ['id' => '\d+']]);
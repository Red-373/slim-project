<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

//require_once('src/Module2/Unit2/Singleton.php');


/*$singleton = new Singleton();

$singleton = Singleton::getInstance();
$singleton->add();
var_dump($singleton->getCounter());

$singleton2 = Singleton::getInstance();
$singleton2->add();
var_dump($singleton2->getCounter());*/

// Сокращеный тернарный оператор
/*echo ('' ?? 'FALSE'); // isEmpty
echo ('' ?: 'FALSE'); // isNull*/

/*$a = 5;

function test(int $a)
{
    return function () use ($a)
    {
        $a = 6;
        return $a;
    };
}

echo (test($a))() . PHP_EOL;
echo $a . PHP_EOL;*/

/*require_once('src/Module2/Unit4/01/demo07/index.php');*/

/*require_once('vendor/autoload.php');

use Module2\Unit2\Singleton;

$singleton = Singleton::getInstance();
$singleton->add();
var_dump($singleton->getCounter());

$singleton2 = Singleton::getInstance();
$singleton2->add();
var_dump($singleton2->getCounter());*/


//require_once(__DIR__ . '/src/Module2/Dispatcher/index.php');

/*function parse(string $fileContent): array
{
    return [$fileContent];
}

echo parse(file_get_contents('http://google.com')) . PHP_EOL;*/

require_once(__DIR__ . '/src/Framework/public/index.php');
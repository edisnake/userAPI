<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$dbConnection = \App\api\DbConfig::getDBConnection();
$c = new \Slim\Container();

// Override the default Error Handlers

$c['notFoundHandler'] = function ($c)
{
    return function ($request, $response) use($c)
    {
        return $c['response']->withJson(array(
            'Invalid Request'
        ), 400);
    };
};

$c['notAllowedHandler'] = function ($c)
{
    return function ($request, $response) use($c)
    {
        return $c['response']->withJson(array(
            'Invalid Request'
        ), 400);
    };
};

$c['errorHandler'] = function ($c)
{
    return function ($request, $response, $error) use($c)
    {
        return $c['response']->withJson(array(
            'Internal server error'
        ), 500);
    };
};

$app = new \Slim\App($c);

$container = $app->getContainer();

// loading routes for user profile operations
require '../app/api/userProfile.php';

$app->run();


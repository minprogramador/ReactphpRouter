<?php

use App\Router;
use React\EventLoop\Factory;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

require __DIR__. '/vendor/autoload.php';

$loop   = Factory::create();
$router = new Router();

$server = new React\Http\Server($loop, function (ServerRequestInterface $request) use(&$router){

    $router->get('/doc/(.*)', function ($doc) {
        return new Response(200,array('Content-Type' => 'text/plain'),"Hello World! {$doc}\n");
    });
    
    $router->post('/doc', function () use(&$request){
        $data = $request->getParsedBody();
        return new Response(200,array('Content-Type' => 'text/plain'),"Hello xxxxx {$data['nome']}!\n");
    });
    
    return $router->run($request->getMethod(), $request->getUri()->getPath());

});

$socket = new React\Socket\Server(8080, $loop);
$server->listen($socket);
$loop->run();



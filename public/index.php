<?php
require '../vendor/autoload.php';
require '../app/Model.php';

$app = new \Slim\Slim();
$app->config('templates.path', '../templates/');

$m = new Model();

// Routes

// Page-specific routes

$app->get('/',
  function() use($app) {
    $app->render( 'main.php' );
  }
);

// API-specific routes

$app->post('/api/login', 
  function() use($app, $m){
    $req = $app->request();
    $u = $req->post('u');
    $p = $req->post('p');
    if( ! is_null($m->getAuthUser($u, $p)) ){
      $response = $app->response();
      $response['Content-Type'] = 'application/json';
      $response->status(200);
      $response->body( 'Access Granted' );
    }
    else{
      //403
      $app->halt(403, 'Access Denied.');
    }
});

$app->get('/api/games', 
  function() use($app, $m) {
    return $m->getGames();
  }
);

$app->get('/api/locations/',
  function() use($app, $m) {
    $list = $m->getLocations();
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->status(200);
    $response->body( json_encode($list) );
  }
);

$app->map('/api/sessions(/:sessionId)',
  function($sessionId=null) use($app, $m) {
    $req = $app->request();

    if( $req->isGet() ) {
      //optional query string params
      $count = $req->params('count');
      
      $sessionsList = $m->getSessions();
      $response = $app->response();
      $response['Content-Type'] = 'application/json';
      $response->status(200);
      $response->body( json_encode($sessionsList) );
    }
    elseif( $req->isPost() ) {
      //store the session
      $reqBody = json_decode( $req->getBody() );
      $session = $m->saveSession($reqBody);

      $response = $app->response();
      $response['Content-Type'] = 'application/json';
      $response['Location'] = '/api/sessions/' . $session->id;
      $response->status(201);
      //according to rest practices, post doesn't need a body, but we will send it back anyway
      $response->body($session);
    }
    elseif( $req->isPut() ) {
      //@todo
    }
    elseif( $req->isDelete() ) {
      //@todo
    }
  }
)->via('GET', 'POST', 'PUT', 'DELETE');

$app->map('/api/sessions/:sessionId/buyins(/:buyinId)', 
  function($sessionId, $buyinId=null) use ($app, $m){
    $req = $app->request();
    if( $req->isGet() ){
      $response = $app->response();
      $response['Content-Type'] = 'application/json';
      $response->status(200);
      $response->body( json_encode($m->getBuyins($sessionId)) );
    }
  }
)->via('GET', 'POST', 'PUT', 'DELETE');

//start app
$app->run();
<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/PersonaApi.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/MWparaCORS.php';
require_once './clases/MWparaAutentificar.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);


/* LLAMADA A METODOS DE INSTANCIA DE UNA CLASE */




$app->group('/Orders', function () {


    $this->get('/', \OrdersApi::class . ':TraerTodo')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

    $this->get('/{id}', \OrdersApi::class . ':Traer')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

    $this->post('/', \OrdersApi::class . ':Cargar');

    $this->delete('/', \OrdersApi::class . ':Borrar');

    $this->put('/', \OrdersApi::class . ':Modificar');

})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');




$app->run();


?>
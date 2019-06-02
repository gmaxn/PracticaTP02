<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require_once '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/PersonaApi.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);

/* LLAMADA A METODOS DE INSTANCIA DE UNA CLASE */

$app->group('/Personas', function () {
 
  $this->get('/', \PersonaApi::class . ':TraerTodo');
 
  $this->get('/{id}', \PersonaApi::class . ':Traer');

  $this->post('/', \PersonaApi::class . ':Cargar');

  $this->delete('/', \PersonaApi::class . ':Borrar');

  $this->put('/', \PersonaApi::class . ':Modificar');
     
});

$app->run();

?>
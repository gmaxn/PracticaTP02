<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require './clases/AccesoDatos.php';
require './clases/PersonaApi.php';
require './clases/MWparaCORS.php';
require './clases/MWparaAutentificar.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

/* LLAMADA A METODOS DE INSTANCIA DE UNA CLASE */

$app->group('/Personas', function () {
 
  $this->get('/', \PersonaApi::class . ':TraerTodo')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $this->get('/{id}', \PersonaApi::class . ':Traer')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  $this->post('/', \PersonaApi::class . ':Cargar');

  $this->delete('/', \PersonaApi::class . ':Borrar');

  $this->put('/', \PersonaApi::class . ':Modificar');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->run();

?>
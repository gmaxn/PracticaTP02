<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/PersonaApi.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/MWparaCORS.php';
require_once './clases/MWparaAutentificar.php';

use \App\Models\Persona as PersonaORM;
require_once './app/models/Persona.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db'] = [
            'driver'=>'mysql',
            'host'=>'localhost',
            'database'=>'utn',
            'username'=>'root',
            'password'=>'',
            'charset'=>'utf8',
            'collation'=>'utf8_unicode_ci',
            'prefix'=>'',
        ];



$app = new \Slim\App(["settings" => $config]);


$container = $app->getContainer();
$dbSettings = $container->get('settings')['db'];

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection($dbSettings);
$capsule->bootEloquent();
$capsule->setAsGlobal();

//http://www.slimframework.com/docs/v3/handlers/error.html
$c = $container;

$c['errorHandler'] = function ($c) {

    return function ($request, $response, $exception) use ($c) {

        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Un error no controlado!');
    };
};

$c['notFoundHandler'] = function ($c) {

    return function ($request, $response) use ($c) {

        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('No es una ruta correcta');
    };
};

$c['notAllowedHandler'] = function ($c) {

    return function ($request, $response, $methods) use ($c) {

        return $response->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write('solo se puede por: ' . implode(', ', $methods));
    };
};

$c['phpErrorHandler'] = function ($c) {

    return function ($request, $response, $error) use ($c) {

        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Algo paso con tu PHP!');
    };
};


/* LLAMADA A METODOS DE INSTANCIA DE UNA CLASE */

$app->group('/Personas', function () {
 
  $this->get('/', \PersonaApi::class . ':TraerTodo')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $this->get('/{id}', \PersonaApi::class . ':Traer')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  $this->post('/', \PersonaApi::class . ':Cargar');

  $this->delete('/', \PersonaApi::class . ':Borrar');

  $this->put('/', \PersonaApi::class . ':Modificar');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');









/* LLAMADA a funciones del ORM */

$app->group('/orm', function () {

  $this->get('/', function () {
    
    echo  "Traer todas las Personas <br>";
    $personas = PersonaORM::all();
    echo $personas->toJson();
    echo "<br><br><br>";



    echo "Agregar Persona<br>";
    $persona = new \App\Models\Persona();

    $persona->nombre = "Frodo";
    $persona->apellido = "Baggins";
    $persona->emial = "fbaggins@gmail.com";
    $persona->user = "fbaggins";
    $persona->pass = "fbaggins";

    $persona->save();

    echo $persona->toJson();
    echo "<br><br><br>";



    echo "Traer una persona por id<br>";
    $otraPersona = $persona->find(20);
    echo $otraPersona->toJson();
    echo "<br><br><br>";


    echo 'Modificar esa persona<br>';
    $otraPersona->nombre = "Frodo";
    $otraPersona->apellido = "Baggins";
    $otraPersona->emial = "fbaggins@gmail.com";
    $otraPersona->user = "fbaggins";
    $otraPersona->pass = "fbaggins";

    $otraPersona->save();

    echo $otraPersona->toJson();
    echo "<br><br><br>";
    
    

    echo 'Buscar todas las personas con el nombre Gandalf<br>';
    $respuesta = $persona->where('nombre', "=", "Gandalf")->get();
    echo $respuesta->toJson();
    echo "<br><br><br>";



    echo 'Buscar la primer ocurrencia con el nombre Maximiliano<br>';
    $respuesta= $persona->where('nombre', "=" , "Maximiliano")->first();
    echo $respuesta->toJson();    
    echo "<br><br><br>";



    echo 'buscar la perosna where nombre <br>';
    $respuesta = $persona->whereFirstName("Gandalf")->first();
    echo $respuesta->toJson();
    echo "<br><br><br>";



    echo 'Borrar una Persona<br>';
    $respuesta->delete();
    echo $respuesta->toJson();

  });


})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');



$app->run();
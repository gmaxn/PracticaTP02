<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/Persona.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);



$app->get('[/]', function (Request $request, Response $response) {

    $response->getBody()->write("GET => Bienvenido!!!, a SlimFramework");
    return $response;

});

$app->post('[/]', function (Request $request, Response $response) {

    $response->getBody()->write("POST => Bienvenido!!!, a SlimFramework");
    return $response;

});

$app->put('[/]', function (Request $request, Response $response) {

    $response->getBody()->write("PUT => Bienvenido!!!, a SlimFramework");
    return $response;

});

$app->delete('[/]', function (Request $request, Response $response) {

    $response->getBody()->write(" DELETE => Bienvenido!!!, a SlimFramework");
    return $response;

});

///////////////////////////////////////////////////////////////////


$app->get('/datos/', function (Request $request, Response $response) {

    $datos = array(
        'nombre'=>'John',
        'apellido'=>'Doe',
        'email'=>'jdoe@gmail.com',
        'user'=>'jdoe',
        'pass'=>'admin',
    );

    $newResponse = $response->withJson($datos, 200);

    return $newResponse;

});

$app->post('/datos/', function (Request $request, Response $response) {

    $ArrayDeParametros = $request->getParsedBody();

    $objeto = new stdclass();

    $objeto->nombre = $ArrayDeParametros['nombre'];
    $objeto->apellido = $ArrayDeParametros['apellido'];
    $objeto->email = $ArrayDeParametros['email'];
    $objeto->user = $ArrayDeParametros['user'];
    $objeto->pass = $ArrayDeParametros['pass'];

    $newResponse = $response->withJson($objeto, 200);

    return $newResponse;

});

///////////////////////////////////////////////////////////////////

/* Atender todos los verbos de HTTP */
$app->any('/cualquiera/[{id}]', function ($request, $response, $args) {
    
    //var_dump($request->getMethod());

    $id = $args['id'];
    $response->getBody()->write("cualquier verbo de ajax parametro: $id ");

    return $response;
});

/* Atender algunos de los verbos de HTTP */
$app->map(['GET', 'POST'], '/mapeado', function ($request, $response, $args) {

    //var_dump($request->getMethod());


    $response->getBody()->write("Solo POST y GET");

});

/* Agrupacion de ruta */
$app->group('/saludo', function () {

    $this->get('/{nombre}', function ($request, $response, $args) {

        $nombre = $args['nombre'];

        $response->getBody()->write("HOLA, Bienvenido <h1>$nombre</h1> a la apirest de 'Personas'");
    });

    $this->get('/', function ($request, $response, $args) {

        $response->getBody()->write("HOLA, Bienvenido a la apirest de 'Personas'... ingresá tu nombre");
    });
 
    $this->post('/', function ($request, $response, $args) {

        $response->getBody()->write("HOLA, Bienvenido a la apirest por post");
    });
     
});

/* Agrupacion de ruta y mapeado */
$app->group('/usuario/{id:[0-9]+}', function () {

    $this->map(['POST', 'DELETE'], '', function ($request, $response, $args) {

        $response->getBody()->write("Borro el usuario con el id pasado en la ruta");
    });

    $this->get('/nombre', function ($request, $response, $args) {

        $response->getBody()->write("Retorno nombre de usuario con id pasado en la ruta" );

    });
});

/* LLAMADA A METODOS DE INSTANCIA DE UNA CLASE */
$app->group('/Personas', function () {   

    $this->get('/', \Persona::class . ':readAll');
    $this->get('/{id}', \Persona::class .':read');
    $this->put('/', \Persona::class . ':update');
    $this->delete('/', \Persona::class . ':delete');

    //se puede tener funciones definidas
    /* SUBIDA DE ARCHIVOS */
    $this->post('/', function (Request $request, Response $response) {

        $ArrayDeParametros = $request->getParsedBody();
		
		$nombre = $ArrayDeParametros['nombre'];
		$apellido = $ArrayDeParametros['apellido'];
		$email = $ArrayDeParametros['email'];
		$usuario = $ArrayDeParametros['user'];
		$pass = $ArrayDeParametros['pass'];

		$persona = new Persona();

		$persona->nombre = $nombre;
		$persona->apellido = $apellido;
		$persona->email = $email;
		$persona->usuario = $usuario;
		$persona->pass = $pass;

		$persona->create();

		$archivos = $request->getUploadedFiles();
		$destino = "./fotos/";

		$nombreAnterior = $archivos['foto']->getClientFilename();
		$extension = explode(".", $nombreAnterior);
		$extension = array_reverse($extension)[0];

		$archivos['foto']->moveTo($destino . $nombre . "." . $extension);

		$response->getBody()->write("Se guardó la persona");

        return $response;

    });
});


$app->run();
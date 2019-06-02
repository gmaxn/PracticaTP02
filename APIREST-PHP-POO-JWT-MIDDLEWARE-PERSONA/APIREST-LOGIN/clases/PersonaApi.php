<?php
require_once 'Persona.php';
require_once 'IApiUsable.php';

class PersonaApi extends Persona implements IApiUsable
{

	public function TraerTodo($request, $response, $args)
	{ 
		$personas = Persona::readAll();
		$response = $response->withJson($personas, 200);

		return $response;
	}

	public function Traer($request, $response, $args)
	{
		$id = $args['id'];

		$persona = Persona::read($id);
		
		$response = $response->withJson($persona, 200);
		
		return $response;
	}

	public function Cargar($request, $response, $args)
	{
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



		
/*
		$archivos = $request->getUploadedFiles();
		$destino = "./fotos/";

		$nombreAnterior = $archivos['foto']->getClientFilename();
		$extension = explode(".", $nombreAnterior);
		$extension = array_reverse($extension)[0];

		$archivos['foto']->moveTo($destino . $nombre . "." . $extension);

		$response->getBody()->write("Se guardó la persona");
*/
		return $response;
	}


	public function Modificar($request, $response, $args)
	{
		$ArrayDeParametros = $request->getParsedBody();

		$persona = new Persona();

		$persona->id = $ArrayDeParametros['id'];
		$persona->nombre = $ArrayDeParametros['nombre'];
		$persona->apellido = $ArrayDeParametros['apellido'];
		$persona->email = $ArrayDeParametros['email'];
		$persona->user = $ArrayDeParametros['user'];
		$persona->pass = $ArrayDeParametros['pass'];

		$resultado = $persona->update();

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->resultado = $resultado;
		
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function Borrar($request, $response, $args)
	{
		$ArrayDeParametros = $request->getParsedBody();


		$id = $ArrayDeParametros['id'];
		$persona = new Persona();
		$persona->id = $id;

		$cantidadDeBorrados = $persona->delete();

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->cantidad = $cantidadDeBorrados;


		if ($cantidadDeBorrados > 0) 
		{
			$objDelaRespuesta->resultado = "algo borro!!!";
		} 
		else 
		{
			$objDelaRespuesta->resultado = "no Borro nada!!!";
		}


		$newResponse = $response->withJson($objDelaRespuesta, 200);
		
		return $newResponse;
	}


}

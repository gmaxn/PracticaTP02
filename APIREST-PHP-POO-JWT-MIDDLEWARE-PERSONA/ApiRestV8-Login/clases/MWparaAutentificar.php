<?php

require_once "AutentificadorJWT.php";
class MWparaAutentificar
{
	public function VerificarUsuario($request, $response, $next)
	{

		if ($request->isGet()) 
		{
			$response->getBody()->write('<p>NO necesita credenciales para los get </p>');
			$response = $next($request, $response);
			
		} 
		else 
		{
			$response->getBody()->write('<p>verifico credenciales</p>');
			$ArrayDeParametros = $request->getParsedBody();

			$nombre = $ArrayDeParametros['nombre'];
			$tipo = $ArrayDeParametros['tipo'];

			if ($tipo == "administrador") 
			{
				$response->getBody()->write("<h3>Bienvenido $nombre </h3>");
				$response = $next($request, $response);
			} 
			else 
			{
				$response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
			}

		}

		$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		return $response;
	}

	public function VerificarUsuario($request, $response, $next)
	{
		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->respuesta = "";

		if ($request->isGet()) 
		{
			$response->getBody()->write('<p>NO necesita credenciales para los get </p>');
			$response = $next($request, $response);
		} 
		else 
		{
			$response->getBody()->write('<p>verifico credenciales</p>');
			$ArrayDeParametros = $request->getParsedBody();

			$nombre = $ArrayDeParametros['nombre'];
			$tipo = $ArrayDeParametros['tipo'];

			if ($tipo == "administrador") 
			{
				$response->getBody()->write("<h3>Bienvenido $nombre </h3>");












			} 
			else 
			{
				$response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
			}

			$token = AutentificadorJWT::CrearToken($datos);


		/*
			$arrayConToken = $request->getHeader('token');
			$token = $arrayConToken[0];			
		*/

			//var_dump($token);
			$objDelaRespuesta->esValido = true;

			try 
			{
				//$token = "";
				AutentificadorJWT::verificarToken($token);
				$objDelaRespuesta->esValido = true;
			} 
			catch (Exception $e) 
			{
				//guardar en un log
				$objDelaRespuesta->excepcion = $e->getMessage();
				$objDelaRespuesta->esValido = false;
			}
			if ($objDelaRespuesta->esValido) 
			{
				if ($request->isPost()) 
				{
					// el post sirve para todos los logeados			    
					$response = $next($request, $response);
				} 
				else 
				{
					$payload = AutentificadorJWT::ObtenerData($token);
					//var_dump($payload);

					// DELETE, PUT y DELETE sirve para todos los logeados y admin
					if ($payload->perfil == "Administrador") 
					{
						$response = $next($request, $response);
					} 
					else 
					{
						$objDelaRespuesta->respuesta = "Solo administradores";
					}
				}
			} 
			else 
			{
				//$response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
				$objDelaRespuesta->respuesta = "Solo usuarios registrados";
				$objDelaRespuesta->elToken = $token;
			}
		}
		if ($objDelaRespuesta->respuesta != "") 
		{
			$nueva = $response->withJson($objDelaRespuesta, 401);
			return $nueva;
		}

		//$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		return $response;
	}
}

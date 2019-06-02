<?php

require_once "AutentificadorJWT.php";
require_once "Persona.php";


class MWparaAutentificar
{
	public function VerificarUsuario($request, $response, $next)
	{
		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->respuesta = "";

		$response->getBody()->write('<p>verifico credenciales</p>');

		$ArrayDeParametros = $request->getParsedBody();

		$user = $ArrayDeParametros['user'];
		$pass = $ArrayDeParametros['pass'];
		$usuario = Persona::readByUserPass($user, $pass);

		var_dump($usuario);

		//perfil = Administrador (todos)
		$datos = array(
			'usuario' => $usuario->email, 
			'perfil' => $usuario->rol, 
			'alias' => $usuario->user
		);

		var_dump($datos);
		

		$token = AutentificadorJWT::CrearToken($datos);
		$objDelaRespuesta->esValido = true;

		try {
			AutentificadorJWT::verificarToken($token);
			$objDelaRespuesta->esValido = true;
		} 
		catch (Exception $e) {
			//guardar en un log
			$objDelaRespuesta->excepcion = $e->getMessage();
			$objDelaRespuesta->esValido = false;
		}


		if ($objDelaRespuesta->esValido) 
		{
			if ($request->isPost())
			{
				$payload = AutentificadorJWT::ObtenerData($token);
				//var_dump($payload);

				if ($payload->perfil == "admin") 
				{
					$response = $next($request, $response);
				} 
				else 
				{
					$objDelaRespuesta->respuesta = "Solo administradores";
				}
			}
		} 
		

		if ($objDelaRespuesta->respuesta != "") 
		{
			$nueva = $response->withJson($objDelaRespuesta, 401);
			return $nueva;
		}

		$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		return $response;
	}
}

<?php

	interface IApiUsable
	{ 	
		public function TraerTodo($request, $response, $args); 
		public function Cargar($request, $response, $args);
		public function Traer($request, $response, $args); 
		public function Modificar($request, $response, $args);
		public function Borrar($request, $response, $args);
	}
	
?>
<?php
class Persona
{
	public $id;
	public $nombre;
	public $apellido;
	public $email;
	public $user;
	public $pass;
	public $rol;
	

	public static function readAll()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT PersonID as id, 
			FirstName as nombre, 
			LastName as apellido,
			Email as email,
			User as user,
			Pass as pass,
			Rol as rol
			FROM Persons;
		");

		$consulta->execute();

		return $consulta->fetchAll(PDO::FETCH_CLASS, "Persona");
	}

	public static function readByUserPass($user, $pass)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			
		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT PersonID as id, 
			FirstName as nombre, 
			LastName as apellido,
			Email as email,
			User as user,
			Pass as pass,
			Rol as rol
			FROM Persons
			WHERE User=? AND Pass=?;
		");

		$consulta->execute( array($user, $pass) );

		$persona = $consulta->fetchObject('Persona');
		
		return $persona;	
	}


/*

	public static function deleteByName($nombre)
	{

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
			DELETE 
			FROM Persons 				
			WHERE FirstName='$nombre';
		");

		$consulta->execute();
		return $consulta->rowCount();
	}
*/
	public function create()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("

			INSERT INTO Persons (FirstName, LastName, Email, User, Pass, Rol) 
			values (
			'$this->nombre',
			'$this->apellido',
			'$this->email',
			'$this->user',
			'$this->pass',
			'$this->rol'
			)

		");

		$consulta->execute();

		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

/*
	public static function read($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT PersonID as id, 
			FirstName as nombre, 
			LastName as apellido,
			Email as email,
			User as user,
			Pass as pass 
			FROM Persons 
			WHERE PersonID=$id;
		");

		$consulta->execute();

		$persona = $consulta->fetchObject('Persona');

		return $persona;				
	}
	public function update()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			
			UPDATE Persons SET
			FirstName='$this->nombre',
			LastName='$this->apellido',
			Email='$this->email',
			User='$this->user',
			Pass='$this->pass' 
			WHERE PersonID='$this->id';
		");

		return $consulta->execute();
	}
	public function delete()
	{

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			DELETE 
			FROM Persons 				
			WHERE PersonID='$this->id';
		");

		$consulta->execute();

		return $consulta->rowCount();
	}
	///////////////////////////////////////////////


	public function mostrarDatos()
	{
		return "Metodo mostar:" . $this->titulo . "  " . $this->cantante . "  " . $this->año;
	}


	*/
}

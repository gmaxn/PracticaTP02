<?php

class ComandaCocina
{
    public $orderDateTime; // 
	public $orderId;       // G5DFD
	public $articleId;     // L90LL
	public $quantity;      // 4
	public $status;        // IN PROGRESS
	
	public static function readAll()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT 
			OrderID, 
			ArticleID, 
			Quantity,
			Status,
			FROM Summary
		");

		$consulta->execute();

		return $consulta->fetchAll(PDO::FETCH_CLASS, "OrderItem");
	}
	public function create()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("

			INSERT INTO Summary 
			values (
				'$this->orderId',
				'$this->articleCode',
				'$this->quantity',
				'$this->status',
			);
		");

		$consulta->execute();

		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	public static function read($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT 
			OrderID, 
			ArticleID, 
			Quantity,
			Status,
			FROM Summary
			WHERE OrderID=$id;
		");

		$consulta->execute();

		$persona = $consulta->fetchObject('OrderItem');

		return $persona;				
	}
	public function update()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			
			UPDATE Summary SET
			OrderID='$this->orderId, 
			ArticleID='$this->articleId, 
			Quantity='$this->quantity,
			Status='$this->status,
			WHERE OrderID='$this->orderId';
		");

		return $consulta->execute();
	}
	public function delete()
	{

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			DELETE 
			FROM OrderItem 				
			WHERE OrderID='$this->orderId';
		");

		$consulta->execute();

		return $consulta->rowCount();
	}
}
?>
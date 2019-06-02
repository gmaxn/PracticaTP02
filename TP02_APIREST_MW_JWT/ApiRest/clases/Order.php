<?php
class Order
{
	public $orderId; 	   // G5DFD
	public $customerId;    // HX67F
	public $orderDateTime; // 2019-06-01 20:30:23
	public $deliveryTime;  // 2019-06-01 21:05:00
	public $orderStatus;   // IN PROGRESS
	
	public static function readAll()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
			SELECT 
			OrderID, 
			CustomerID, 
			OrderDateTime,
			DeliveryTime,
			OrderStatus,
			FROM Orders
		");

		$consulta->execute();

		return $consulta->fetchAll(PDO::FETCH_CLASS, "Order");
	}
	public function create()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("

			INSERT INTO Order 
			values (
				'$this->orderId',
				'$this->customerId',
				'$this->orderDateTime',
				'$this->delivetyTime',
				'$this->orderStatus', 
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
			CustomerID, 
			OrderDateTime,
			DeliveryTime,
			OrderStatus,
			FROM Orders
			WHERE OrderCode=$id;
		");

		$consulta->execute();

		$persona = $consulta->fetchObject('Order');

		return $persona;				
	}
	public function update()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			
			UPDATE Orders SET
			OrderID='$this->orderId, 
			CustomerID='$this->orderId, 
			OrderDateTime='$this->orderDateTime,
			DeliveryTime='$this->orderDeliveryTime,
			OrderStatus='$this->orderStatus,
			WHERE OrderID='$this->orderId';
		");

		return $consulta->execute();
	}
	public function delete()
	{

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
		$consulta = $objetoAccesoDato->RetornarConsulta("
			DELETE 
			FROM Orders 				
			WHERE OrderID='$this->orderId';
		");

		$consulta->execute();

		return $consulta->rowCount();
	}
}

?>

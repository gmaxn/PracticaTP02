<?php
require_once 'Order.php';
require_once 'OrderItem.php';
require_once 'IApiUsable.php';

class OrderApi extends Order implements IApiUsable
{

	public function TraerTodo($request, $response, $args)
	{ 
		$personas = Order::readAll();
		$response = $response->withJson($personas, 200);

		return $response;
	}



	public function Cargar($request, $response, $args)
	{
		$arrayDeParametros = $request->getParsedBody();
        
        $orderId = $arrayDeParametros['orderId']; 	          // G5DFD
        $customerId = $arrayDeParametros['customerId'];       // HX67F
        $orderDateTime = date("Y-m-d H:i:s"); // 2019-06-01 20:30:23
        
        $start = $orderDateTime;
        $minutos = $arrayDeParametros['minutos'];
        $deliveryTime = date("Y-m-d H:i:s", strtotime('+' + $minutos + ' minutes', strtotime($start)));   // 2019-06-01 21:05:00
        
        $orderStatus = $arrayDeParametros['orderStatus'];     // IN PROGRESS
        
        
        $order = new Order();

		$order->orderId = $orderId;
		$order->customerId = $customerId;
		$order->orderDateTime = $orderDateTime;
		$order->deliveryTime = $deliveryTime;
		$order->orderStatus = $orderStatus;


        var_dump($order);

		//$order->create();
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





}

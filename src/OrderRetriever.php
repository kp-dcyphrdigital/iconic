<?php

namespace SYG\Iconic;

use SYG\Iconic\ApiClient;

class OrderRetriever
{
	private $iconicClient;
	private $orderId;
	public function __construct(ApiClient $iconicClient)
	{
		$this->iconicClient = $iconicClient;
	}

	public function retrieve($orderId)
	{
		$this->orderId = $orderId;
		return (object) array_merge( 
			(array) $this->getOrder(), 
			(array) $this->getOrderItems()
		);
	}

	private function getOrder()
	{
		return json_decode( $this->iconicClient->getData('GetOrder', ['OrderId' => $this->orderId]) )
				->SuccessResponse->Body->Orders->Order;	
	}

	private function getOrderItems()
	{
		return json_decode( $this->iconicClient->getData('GetOrderItems', ['OrderId' => $this->orderId]) )
			->SuccessResponse->Body;		
	}

}
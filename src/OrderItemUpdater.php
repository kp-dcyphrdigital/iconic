<?php

namespace SYG\Iconic;

use SYG\Iconic\ApiClient;

class OrderItemUpdater
{
	private $iconicClient;

	public function __construct(ApiClient $iconicClient)
	{
		$this->iconicClient = $iconicClient;
	}

	public function updateToShipped($orderItemId, $shipmentProvider, $trackingCode)
	{
		return json_decode( $this->iconicClient->postData(SetStatusToReadyToShip', ['OrderItemIds' => [$orderItemId], 'DeliveryType' => 'dropship', 'ShippingProvider' => $shipmentProvider, 'TrackingNumber' => $trackingCode]) )
				->SuccessResponse->Body->Orders->Order;	
	}

}
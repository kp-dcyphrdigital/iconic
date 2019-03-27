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

	public function updateToReadyToShip($orderItemIds, $shipmentProvider, $trackingCode)
	{
		return json_decode( $this->iconicClient->getData('SetStatusToReadyToShip', ['OrderItemIds' => '[' . $orderItemIds . ']', 'DeliveryType' => 'dropship', 'ShippingProvider' => $shipmentProvider, 'TrackingNumber' => $trackingCode]) );	
	}

	public function updateToShipped($orderItemId)
	{
		return json_decode( $this->iconicClient->getData('SetStatusToShipped', ['OrderItemId' => $orderItemId]) );	
	}

}
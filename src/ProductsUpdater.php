<?php

namespace SYG\Iconic;

use SYG\Iconic\ApiClient;
use SYG\Iconic\Exceptions\{InvalidRequestDataException, InvalidApiCredentialsException};

class ProductsUpdater
{
	private $iconicClient;

	public function __construct(ApiClient $iconicClient)
	{
		$this->iconicClient = $iconicClient;
	}

	public function updateProducts($products)
	{
		$payload = view('iconic::product-updater-payload', ['products' => $products])->render();
		$response = json_decode( $this->iconicClient->postData('ProductUpdate', $payload) );
		
		if(isset($response->ErrorResponse) && $response->ErrorResponse->Head->ErrorCode == 9) {
			throw new InvalidApiCredentialsException;
		}

		if(isset($response->ErrorResponse) && $response->ErrorResponse->Head->ErrorCode == 16) {
			throw new InvalidRequestDataException;
		}

		return $response->SuccessResponse->Body;	
	}

}
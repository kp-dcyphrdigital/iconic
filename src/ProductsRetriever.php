<?php

namespace SYG\Iconic;

use SYG\Iconic\ApiClient;
use SYG\Iconic\Exceptions\{InvalidRequestDataException, InvalidApiCredentialsException};

class ProductsRetriever
{
	private $iconicClient;

	public function __construct(ApiClient $iconicClient)
	{
		$this->iconicClient = $iconicClient;
	}

	public function getProducts($offset = 0, $limit = 1000)
	{
		$response = json_decode( $this->iconicClient->getData('GetProducts', ['Offset' => $offset, 'Limit' => $limit]) );
		
		if(isset($response->ErrorResponse) && $response->ErrorResponse->Head->ErrorCode == 9) {
			throw new InvalidApiCredentialsException;
		}

		if(isset($response->ErrorResponse) && $response->ErrorResponse->Head->ErrorCode == 16) {
			throw new InvalidRequestDataException;
		}

		return $response->SuccessResponse->Body->Products->Product;	
	}

}
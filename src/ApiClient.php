<?php 

namespace SYG\Iconic;

use SYG\Iconic\Exceptions\ActionNotSupportedException;

class ApiClient
{
	private const ALLOWED_GET_METHODS = ['GetBrands', 'GetOrder', 'GetOrderItems', 'GetOrderComments'];
	private const ALLOWED_POST_METHODS = ['CreateWebhook', 'DeleteWebhook'];

	private $globalParameters;
	private $httpClient;

	public function __construct($httpClient, $globalParameters)
	{
		$this->globalParameters = $globalParameters;
		$this->httpClient = $httpClient;
	}

	public function getData($action, $parameters = [])
	{
		if (! in_array($action, self::ALLOWED_GET_METHODS) ) {
			throw new ActionNotSupportedException("This GET method is not currently supported");
		}

		return $this->httpClient->get(
			config('iconic.apiUrl'), 
			['query' => $this->prepareQueryString($action, $parameters)] 
		)->getBody();
	}

	public function postData($action, $payload)
	{
		if (! in_array($action, self::ALLOWED_POST_METHODS) ) {
			throw new ActionNotSupportedException("This POST method is not currently supported");
		}

		return $this->httpClient->post(
			config('iconic.apiUrl'), 
			['query' => $this->prepareQueryString($action), 'body' => $payload ]
		)->getBody();
	}

	private function prepareQueryString($action, $parameters)
	{
		$parameters = collect($this->globalParameters)
						->merge(['Action' => $action])
						->merge($parameters)
						->sortKeys();
		$queryString = $parameters->map(function($v, $k){
							return rawurlencode($k) . '=' . rawurlencode($v);
						})->implode('&');
		$parameters->put( 'Signature', $this->sign($queryString) );
		return $parameters->toArray();
	}

	private function sign($queryString)
	{
		return rawurlencode(hash_hmac('sha256', $queryString, config('iconic.apiKey'), false));
	}
}
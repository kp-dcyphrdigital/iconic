<?php

namespace SYG\Iconic\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Handler\MockHandler;
use SYG\Iconic\IconicServiceProvider;
use GuzzleHttp\Exception\RequestException;
use SYG\Iconic\Exceptions\ApiNotAvailableException;
use SYG\Iconic\Exceptions\ActionNotSupportedException;

class ApiClientTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            IconicServiceProvider::class,
        ];
    }

    /** @test */
    public function returns_a_success_response()
    {
    	$apiClient = $this->app->make('SYG\Iconic\ApiClient');
    	$this->assertContains("SuccessResponse", $apiClient->getData('GetWebhookEntities')->getContents());
    }

    /** @test */
    public function returns_an_error_response()
    {
    	$apiClient = $this->app->make('SYG\Iconic\ApiClient');
    	$invalidOrderId = 1010;
    	$this->assertContains("ErrorResponse", $apiClient->getData('GetOrder', ['OrderId' => $invalidOrderId])->getContents());
    }

    /** @test */
    public function an_ApiNotAvailable_Exception_is_thrown_if_API_is_unresponsive_for_a_GET_Action()
    {
		$mock = new MockHandler([
		    new RequestException("Error Communicating with Server", new Request('GET', 'test')),
		]);
		$handler = HandlerStack::create($mock);
		$httpClient = new Client(['handler' => $handler]);
        $globalParameters = [
            'UserID' => config('iconic.apiUser'),
            'Version' => '1.0',
            'Timestamp' => now()->format('c'),
            'Format' => 'JSON',
        ];
		$apiClient = new \SYG\Iconic\ApiClient($httpClient, $globalParameters);

		try {
			$apiClient->getData('GetBrands');
		} catch (ApiNotAvailableException $e) {
			$this->assertTrue(true);
			return;
		}

		$this->fail("No exception was thrown even though API is unavailable");
    }

     /** @test */
    public function an_ApiNotAvailable_Exception_is_thrown_if_API_is_unresponsive_for_a_POST_Action()
    {
		$mock = new MockHandler([
		    new RequestException("Error Communicating with Server", new Request('POST', 'test')),
		]);
		$handler = HandlerStack::create($mock);
		$httpClient = new Client(['handler' => $handler]);
        $globalParameters = [
            'UserID' => config('iconic.apiUser'),
            'Version' => '1.0',
            'Timestamp' => now()->format('c'),
            'Format' => 'JSON',
        ];
		$apiClient = new \SYG\Iconic\ApiClient($httpClient, $globalParameters);

		try {
			$apiClient->postData('CreateWebhook', '');
		} catch (ApiNotAvailableException $e) {
			$this->assertTrue(true);
			return;
		}

		$this->fail("No exception was thrown even though API is unavailable");
    }

	/** @test **/
	public function an_unsupported_GET_action_throws_an_ActionNotSupported_Exception()
	{
		$apiClient = $this->app->make('SYG\Iconic\ApiClient');

		try {
			$apiClient->getData('INVALID');
		} catch (ActionNotSupportedException $e) {
			$this->assertTrue(true);
			return;
		}

		$this->fail("Invalid GET Action Was Successful");
	}

	/** @test **/
	public function an_unsupported_POST_action_throws_an_ActionNotSupported_Exception()
	{
		$apiClient = $this->app->make('SYG\Iconic\ApiClient');

		try {
			$apiClient->postData('INVALID', '');
		} catch (ActionNotSupportedException $e) {
			$this->assertTrue(true);
			return;
		}

		$this->fail("Invalid POST Action Was Successful");
	}

}
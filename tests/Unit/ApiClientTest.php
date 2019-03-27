<?php

namespace SYG\Iconic\Tests\Unit;

use Orchestra\Testbench\TestCase;
use SYG\Iconic\IconicServiceProvider;

class ApiClientTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            IconicServiceProvider::class,
        ];
    }

	/** @test **/
	public function base_test()
	{
		dd( $this->app->make('SYG\Iconic\ApiClient') );
	}
}
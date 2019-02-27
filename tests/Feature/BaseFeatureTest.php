<?php

namespace SYG\Iconic\Tests\Feature;

use Orchestra\Testbench\TestCase;

class BaseFeatureTest extends TestCase
{
	/** @test **/
	public function it_tests_if_phpunit_is_setup_right()
	{
		$this->assertTrue(true);
	}
}
<?php

use FuelPHP\Event\Facade\Event;
use FuelPHP\Event\Facade\Queue;

class FacadeTests extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Event::delete(true);
		Queue::delete(true);
	}

	public function testForgeContainer()
	{
		$container = Event::forge();

		$this->assertInstanceOf('FuelPHP\\Event\\Container', $container);
	}

	public function testForgeQueue()
	{
		$container = Queue::forge();

		$this->assertInstanceOf('FuelPHP\\Event\\Queue', $container);
	}

	public function testEventCallForewarding()
	{
		$result = Event::on('event', function(){});

		$this->assertInstanceOf('FuelPHP\\Event\\Container', $result);
	}

	public function testQueueCallForewarding()
	{
		$result = Queue::queue('event');

		$this->assertInstanceOf('FuelPHP\\Event\\Queue', $result);
	}

	public function testEventInstance()
	{
		$result = Event::instance('my_instance');

		$this->assertInstanceOf('FuelPHP\\Event\\Container', $result);
	}

	public function testDeleteQueueInstance()
	{
		$instance = Queue::instance('my_instance');
		$instance->queue('event', array(1, 2, 3));

		Queue::delete('my_instance');

		$instance = Queue::instance('my_instance');
		$payload = $instance->getPayload('event');

		$this->assertEquals($payload, array());
	}
}
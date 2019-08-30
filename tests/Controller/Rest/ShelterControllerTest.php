<?php

namespace App\Tests\Controller\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShelterControllerTest extends WebTestCase
{
	public function testPostShelter()
	{
		$client = static::createClient();

		$client->request('POST', '/api/shelter', ['name' => 'Black Labradors']);

		$this->assertEquals(201, $client->getResponse()->getStatusCode());
	}

	public function testPostShelterWithNoParameters()
	{
		$client = static::createClient();

		$client->request('POST', '/api/shelter');

		$this->assertEquals(422, $client->getResponse()->getStatusCode());
	}

	public function testPostShelterWithGet()
	{
		$client = static::createClient();

		$client->request('GET', '/api/shelter');

		$this->assertEquals(405, $client->getResponse()->getStatusCode());
	}
}
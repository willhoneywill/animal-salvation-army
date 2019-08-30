<?php

namespace App\Tests\Controller\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnimalControllerTest extends WebTestCase
{
	public function testGetAnimal()
	{
		$client = static::createClient();

		$client->request('GET', '/api/animal/1');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}
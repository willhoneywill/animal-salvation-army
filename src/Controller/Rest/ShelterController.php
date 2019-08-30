<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Shelter as Shelter;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ShelterController extends FOSRestController
{
	/**
	 * Creates an Shelter resource
	 * @Rest\Post("/shelter")
	 */
	public function postShelter( Request $request ): View
	{
		if (!$request->get( 'name' )) {
			throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, "This resource requires a name field");
		}

		$entityManager = $this->getDoctrine()->getManager();

		$shelter = new Shelter();
		$shelter->setName( $request->get( 'name' ) );

		$entityManager->persist( $shelter );

		$entityManager->flush();

		return View::create( $shelter, Response::HTTP_CREATED );
	}

	/**
	 * Retrieves an Shelter resource
	 * @Rest\Get("/shelter/{shelterId}")
	 */
	public function getShelter( int $shelterId ): View
	{
		$shelter = $this->getDoctrine()
		                ->getRepository(Shelter::class)
		                ->find($shelterId);

		if (!$shelter) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No shelter found for ID " . $shelterId);
		}

		return View::create( $shelter, Response::HTTP_OK );
	}

	/**
	 * Retrieves a collection of Shelter resource
	 * @Rest\Get("/shelters")
	 */
	public function getShelters(): View
	{
		$shelter = $this->getDoctrine()
		                ->getRepository(Shelter::class)
		                ->findAll();

		if (!$shelter) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No shelter found for ID " . $shelterId);
		}

		return View::create( $shelter, Response::HTTP_OK );
	}

	/**
	 * Updates a Shelter resource
	 * @Rest\Put("/shelter/{shelterId}")
	 */
	public function putShelter( int $shelterId, Request $request ): View
	{
		$shelter = $this->getDoctrine()
		                ->getRepository(Shelter::class)
		                ->find($shelterId);

		if (!$shelter) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No shelter found for ID " . $shelterId);
		}

		$entityManager = $this->getDoctrine()->getManager();

		$shelter->setName( $request->get( 'name' ) );

		$entityManager->persist( $shelter );

		$entityManager->flush();

		return View::create( $shelter, Response::HTTP_OK );
	}

	/**
	 * Updates a Shelter resource
	 * @Rest\Delete("/shelter/{shelterId}")
	 */
	public function deleteShelter( int $shelterId, Request $request ): View
	{
		$shelter = $this->getDoctrine()
		                ->getRepository(Shelter::class)
		                ->find($shelterId);

		if (!$shelter) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No shelter found for ID " . $shelterId);
		}

		$entityManager = $this->getDoctrine()->getManager();

		$shelter->setName( $request->get( 'name' ) );

		$entityManager->remove( $shelter );
		$entityManager->flush();

		return View::create( $shelter, Response::HTTP_OK );
	}

}
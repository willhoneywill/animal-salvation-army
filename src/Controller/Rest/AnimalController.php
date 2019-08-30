<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Animal as Animal;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;



class AnimalController extends FOSRestController
{
	/**
	 * Creates an Animal  resource
	 * @Rest\Post("/animal")
	 */
	public function postAnimal ( Request $request ): View
	{
		if (!$request->get( 'name' )) {
			throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, "This resource requires a name field");
		}

		if (!$request->get( 'breed' )) {
			throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, "This resource requires a breed field");
		}

		$entityManager = $this->getDoctrine()->getManager();

		$animal  = new Animal ();
		$animal->setName( $request->get( 'name' ) );
		$animal->setMedicalCondition( 'healthy' );
		$animal->setPicture( 'doggy.jpg' );
		$animal->setBreed( $request->get( 'breed' ) );
		$animal->setShelterId( 1 );
		$animal->setStatus( 0 );
		$animal->setShelterWorkerId( 1 );

		$entityManager->persist( $animal  );
		$entityManager->flush();

		return View::create( $animal , Response::HTTP_CREATED );
	}

	/**
	 * Retrieves an Animal resource
	 * @Rest\Get("/animal/{animalId}")
	 */
	public function getAnimal ( int $animalId ): View
	{
		$animal  = $this->getDoctrine()
		                ->getRepository(Animal ::class)
		                ->find($animalId);

		if (!$animal ) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No animal found for ID " . $animalId);
		}

		return View::create( $animal, Response::HTTP_OK );
	}

	/**
	 * Retrieves a collection of Animal resource
	 * @Rest\Get("/animals")
	 */
	public function getAnimals(): View
	{
		$animal  = $this->getDoctrine()
		                ->getRepository(Animal ::class)
		                ->findAll();

		if (!$animal ) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No animals found" );

		}

		return View::create( $animal , Response::HTTP_OK );
	}

	/**
	 * Updates a Animal resource
	 * @Rest\Put("/animal/{animalId}")
	 */
	public function putAnimal ( int $animalId, Request $request ): View
	{
		$animal  = $this->getDoctrine()
		                ->getRepository(Animal ::class)
		                ->find($animalId);

		if ( !$animal ) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No animal found for ID " . $animalId);

		}

		$entityManager = $this->getDoctrine()->getManager();

		$animal ->setName( $request->get( 'name' ) );

		$entityManager->persist( $animal );

		$entityManager->flush();

		return View::create( $animal, Response::HTTP_OK );
	}

	/**
	 * Updates a Animal resource
	 * @Rest\Delete("/animal/{animalId}")
	 */
	public function deleteAnimal ( int $animalId, Request $request ): View
	{
		$animal  = $this->getDoctrine()
		                ->getRepository(Animal ::class)
		                ->find($animalId);

		if (!$animal ) {
			throw new HttpException(Response::HTTP_NOT_FOUND, "No animal found for ID " . $animalId);
		}

		$entityManager = $this->getDoctrine()->getManager();

		$animal->setName( $request->get( 'name' ) );

		$entityManager->remove( $animal );
		$entityManager->flush();

		return View::create( $animal, Response::HTTP_OK );
	}

}
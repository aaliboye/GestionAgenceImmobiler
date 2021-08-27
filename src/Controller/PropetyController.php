<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropetyController extends AbstractController
{

    private $repository;

    

    
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
        
        
    }

    /**
     * @Route("/biens", name="propety_index")
     * @return Response
     */

    public function index(): Response
    {
        $properties = new Property();
        $properties= $this->repository->findAll();
        return $this->render('propeties/index.html.twig', [
            'currant_menu' => 'propeties',
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/biens/{title}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */

    public function show($title, $id) : Response
    {
        $property = $this->repository->find($id);

        return $this->render('propeties/show.html.twig', [
            'property' => $property,
            'currant_menu' => 'propeties'
        ]);
    }
}

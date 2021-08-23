<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    private $repository;


    public function __construct(PropertyRepository $repository)
    {
        $this->repository=$repository;
    }
        
    /**
     * @Route("/admin", name="admin_property_index")
     */

    public function index() : Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/properties/index.html.twig', [
            'properties' => $properties,

        ]);
    }

    /**
     * @Route("/admin/property/new", name="admin_property_new")
     */
    public function new(Request $request)
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();

            return $this->redirectToRoute('admin_property_index');
         }

         return $this->render('admin/properties/new.html.twig', [
            'property'=> $property,
            'formu' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/property/{id}", name="admin_property_edit", methods="GET|POST")
     */

     public function edit(Property $property, Request $request)
     {
         $form = $this->createForm(PropertyType::class, $property);
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_property_index');
         }
        return $this->render('admin/properties/edit.html.twig', [
            'property'=> $property,
            'formu' => $form->createView()
        ]);   
     }

     /**
     * @Route("/admin/property/{id}/delete", name="admin_property_delete")
     * @param Property $property
     */

     public function delete(Property $property, Request $request)
     {
      
            $em = $this->getDoctrine()->getManager();
            $em->remove($property);
            $em->flush();

        return $this->redirectToRoute('admin_property_index');

    }



}
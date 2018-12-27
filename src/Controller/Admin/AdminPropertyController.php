<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPropertyController extends AbstractController
{

    /**
     * @var \App\Repository\PropertyRepository
     */
    private $repository;

    /**
     * @param \App\Repository\PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository=$repository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index():Response
    {
        $properties=$this->repository->findAll();
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @param \App\Entity\Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property):Response
    {
        $form=$this->createForm(PropertyType::class,$property);
        return $this->render('admin/property/edit.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }
}
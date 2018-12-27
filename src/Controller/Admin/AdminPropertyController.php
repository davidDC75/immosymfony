<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPropertyController extends AbstractController
{

    /**
     * @var \App\Repository\PropertyRepository
     */
    private $repository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @param \App\Repository\PropertyRepository $repository
     * @param \Doctrine\Common\Persistence\ObjectManager $em
     */
    public function __construct(PropertyRepository $repository,ObjectManager $em)
    {
        $this->repository=$repository;
        $this->em=$em;
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function new(Request $request):Response
    {
        $property=new Property();
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property); // Pour l'ajout l'em ne track pas alors il faut faire un persist (différence avec edit plus bas)
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param \App\Entity\Property $property
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request):Response
    {
        $form=$this->createForm(PropertyType::class,$property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }
}
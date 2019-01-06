<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * Constructeur
     * @param \App\Repository\PropertyRepository $repository
     * @param \Doctrine\Common\Persistence\ObjectManager $em
     */
    public function __construct(PropertyRepository $repository,ObjectManager $em)
    {
        $this->repository=$repository;
        $this->em=$em;
    }

    /**
     * Liste l'ensemble des biens
     * @param \Knp\Component\Pager\PaginatorInterface $paginator
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator,Request $request):Response
    {
        //$properties=$this->repository->findAll();
        $properties=$paginator->paginate(
            $this->repository->findAllAdmin(), // Récupère la query
            $request->query->getInt('page', 1), // Récupère $_GET['page'] et converti en int. Par défaut 1
            10 // limit
        );
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * Ajoute un nouveau bien
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request,TranslatorInterface $translator):Response
    {
        $property=new Property();
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($property); // Pour l'ajout l'em ne track pas alors il faut faire un persist (différence avec edit plus bas)
            $this->em->flush();
            $this->addFlash('success',$translator->trans('admin.property.addSuccess',[],'messages'));
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Modifie un bien
     * @param \App\Entity\Property $property
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request, TranslatorInterface $translator):Response
    {
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setUpdatedAt(new \Datetime('now'));
            $this->em->flush();
            $this->addFlash('success',$translator->trans('admin.property.editSuccess',[],'messages'));
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Supprimer un bien
     * @param \App\Entity\Property $property
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request):Response
    {
        if ( $this->isCsrfTokenValid('delete'.$property->getId(),$request->get('_token')) )
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.property.index');
    }
}
<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;  // pour l'entity manager
use Symfony\Component\HttpFoundation\Response; // Pour la response de la méthode

class PropertyController extends AbstractController
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
    public function __construct(PropertyRepository $repository,ObjectManager $em) {
        $this->repository=$repository; // On injecte le PropertyRepository avec l'autowiring
        $this->em=$em; // On inject l'entity manager
    }

    /**
     * Affiche la liste des biens disponibles.
     * @return Response
     */
    // public function index(PropertyRepository $repository):Response { // On peut injecter le PropertyRepository directement dans la méthode index
    public function index():Response {

        /*
        $property=new Property();
        $property->setTitle('Mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('Une petite description')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Montpellier')
            ->setAddress('15 Boulevard Gambetta')
            ->setPostalCode('34000');
        $em=$this->getDoctrine()->getManager(); // Get Entity Manager
        $em->persist($property);
        $em->flush(); // COMMIT
        */

        /*
        $repository=$this->getDoctrine()->getRepository(Property::class); // Méthode manuelle pour récupèrer le propertyRepository
        */

        //$property=$this->repository->find(1);
        //$property=$this->repository->findAll();
        //$property=$this->repository->findOneBy(['floor'=>4]);

        //$property=$this->repository->findAllVisible(); // On récupère toutes les properties non vendues (visible)
        //dump($property);

        return $this->render('property/index.html.twig',[
            'current_menu'=> 'properties'
        ]);
    }

    /**
     * Affiche un bien
     * @param string $slug
     * @param integer $id
     * @return Response
     */
    public function show($slug,$id):Response { // On peut mettre Property $property en paramètre afin d'économiser une ligne. Pas besoin du find car Symfony utilisera automatiquement l'id de la route
        $property=$this->repository->find($id);

        if ($property->getSlug()!==$slug)
        {
            return $this->redirectToRoute('property.show',[
                'id'=>$property->getId(),
                'slug'=>$property->getSlug()
            ],301);
        }

        return $this->render('property/show.html.twig', [
            'current_menu'=>'properties',
            'property'=>$property
        ]);
    }

}
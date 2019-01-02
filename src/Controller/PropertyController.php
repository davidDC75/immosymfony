<?php
namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;

use App\Repository\PropertyRepository;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;  // pour l'entity manager
use Symfony\Component\HttpFoundation\Response; // Pour la response de la méthode

class PropertyController extends AbstractController
{

    /**
     * $repository
     * @var \App\Repository\PropertyRepository
     */
    private $repository;

    /**
     * $em
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * $translator
     * @var \Symfony\Component\Translation\Translator
     */
    private $translator;

    /**
     * Constructeur
     * @param \App\Repository\PropertyRepository $repository
     * @param \Doctrine\Common\Persistence\ObjectManager $em
     */
    public function __construct(PropertyRepository $repository,ObjectManager $em,TranslatorInterface $translator) {
        $this->repository=$repository; // On injecte le PropertyRepository avec l'autowiring
        $this->em=$em; // On injecte l'entity manager
        $this->translator=$translator; // On injecte le translator
    }

    /**
     * Affiche la liste des biens disponibles.
     * @return Response
     */
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

        // On récupère le type de chauffage
        $tblHeat= [
            0=>$this->translator->trans("heattype.electric",[],'forms'),
            1=>$this->translator->trans("heattype.gas",[],'forms'),
            2=>$this->translator->trans("heattype.fireplace",[],'forms')
        ];


        return $this->render('property/show.html.twig', [
            'current_menu'=>'properties',
            'property'=>$property,
            'heatType'=>$tblHeat[$property->getHeat()]
        ]);
    }

}
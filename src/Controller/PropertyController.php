<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Form\PropertyType;
use App\Entity\PropertySearch;
use \App\Form\PropertySearchType;

use App\Repository\PropertyRepository;

use App\Notification\ContactNotification;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function __construct(PropertyRepository $repository,ObjectManager $em,TranslatorInterface $translator)
    {
        $this->repository=$repository; // On injecte le PropertyRepository avec l'autowiring
        $this->em=$em; // On injecte l'entity manager
        $this->translator=$translator; // On injecte le translator
    }

    /**
     * Affiche la liste des biens disponibles.
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request):Response
    {
        $search=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        $properties=$paginator->paginate(
            $this->repository->findAllVisibleQuery($search), // Récupère la query
            $request->query->getInt('page', 1), // Récupère $_GET['page'] et converti en int. Par défaut 1
            12 // limit
        );

        return $this->render('property/index.html.twig',[
            'current_menu' => 'properties',
            'properties'   => $properties,
            'form'         => $form->createView()
        ]);
    }

    /**
     * Affiche un bien
     * @param string $slug
     * @param integer $id
     * @return Response
     */
    public function show(
        $slug,
        $id,
        Request $request,
        TranslatorInterface $translator,
        ContactNotification $notification
        ):Response // On peut mettre Property $property en paramètre afin d'économiser une ligne. Pas besoin du find car Symfony utilisera automatiquement l'id de la route
    {
        $property=$this->repository->find($id);

        if ($property->getSlug()!==$slug)
        {
            return $this->redirectToRoute('property.show',[
                'id'=>$property->getId(),
                'slug'=>$property->getSlug()
            ],301);
        }

        $contact=new Contact();
        $contact->setProperty($property);
        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);

            $this->addFlash('success',$translator->trans('contact.success',[],'forms'));
            return $this->redirectToRoute('property.show',[
                'id'=>$property->getId(),
                'slug'=>$property->getSlug()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property'     => $property,
            'heatType'     => $this->translator->trans(Property::HEAT[$property->getHeat()],[],'forms'),
            'form'         => $form->createView()
        ]);
    }

}
<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    //private $repository;

    //public __construct(ProperyRepository $repository) {
    //    $this->repository=$repository;
    //}

    /**
     * Affiche la homepage
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository):Response { // On inject le repository ici car ce controller ne comportera qu'une méthode

        $properties=$repository->findLatest();

        return $this->render('pages/home.html.twig',[
            'properties'=>$properties
        ]);
    }
}
<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    /**
     * Affiche la homepage
     * @param \App\Repository\PropertyRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PropertyRepository $repository):Response
    {
        // On injecte le repository ici car ce controller ne comportera qu'une méthode
        $properties=$repository->findLatest();

        return $this->render('pages/home.html.twig',[
            'properties'=>$properties
        ]);
    }
}
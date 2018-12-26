<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PropertyController extends AbstractController {

    /**
     * Affiche la liste des biens disponibles.
     * @return Response
     */
    public function index():Response {
        return $this->render('property/index.html.twig');
    }

}
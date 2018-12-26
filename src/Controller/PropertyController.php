<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PropertyController {

    /**
     * Affiche la liste des biens disponibles.
     * @return Response
     */
    public function index():Response {
        return new Response('Les biens');
    }

}
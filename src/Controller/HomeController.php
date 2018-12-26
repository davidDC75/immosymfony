<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController {
    
    /**
     * @var Twig\Environment
     */
    private $twig;

    public function __construct(Environment $twig) {
        $this->twig=$twig;
    }

    /**
     * Affiche la homepage
     * @return Response
     */
    public function index():Response {
        return new Response($this->twig->render('pages/home.html.twig'));
    }
}
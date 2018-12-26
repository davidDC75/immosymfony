<?php
namespace App\Controller;

use App\Entity\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PropertyController extends AbstractController {

    /**
     * Affiche la liste des biens disponibles.
     * @return Response
     */
    public function index():Response {

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
        $em->flush();

        return $this->render('property/index.html.twig',[
            'current_menu'=> 'properties'
        ]);
    }

}
<?php
namespace App\Controller\Admin;

use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPictureController extends AbstractController
{

    public function delete(Picture $picture, Request $request): Response
    {
        $data=json_decode($request->getContent(),true);

        if ($this->isCsrfTokenValid( 'picture.delete'.$picture->getId(), $data['_token'] )) {
            $em=$this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();
            return new JsonResponse(['success'=>1]);
        }

        return new JsonResponse(['error'=>'Token Invalide'],400);
    }
}
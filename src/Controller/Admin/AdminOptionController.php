<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 */
class AdminOptionController extends AbstractController
{
    /**
     *
     */
    public function index(PaginatorInterface $paginator,OptionRepository $optionRepository,Request $request): Response
    {
        $options=$paginator->paginate(
            $optionRepository->findAllQuery(), // Récupère la query
            $request->query->getInt('page', 1), // Récupère $_GET['page'] et converti en int. Par défaut 1
            10 // limit
        );
        return $this->render('admin/option/index.html.twig', ['options' => $options]);
    }

    /**
     *
     */
    public function new(Request $request,TranslatorInterface $translator): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();
            $this->addFlash('success',$translator->trans('admin.option.addSuccess',[],'messages'));
            return $this->redirectToRoute('admin.option.index');
        }

        return $this->render('admin/option/new.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     */
    public function edit(Request $request, Option $option,TranslatorInterface $translator): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success',$translator->trans('admin.option.editSuccess',[],'messages'));
            return $this->redirectToRoute('admin.option.index', ['id' => $option->getId()]);
        }

        return $this->render('admin/option/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     */
    public function delete(Request $request, Option $option): Response
    {
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.option.index');
    }
}

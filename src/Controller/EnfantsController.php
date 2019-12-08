<?php

namespace App\Controller;

use App\Entity\Enfants;
use App\Form\EnfantsType;
use App\Repository\EnfantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enfants")
 */
class EnfantsController extends AbstractController
{
    /**
     * @Route("/", name="enfants_index", methods={"GET"})
     */
    public function index(EnfantsRepository $enfantsRepository): Response
    {
        return $this->render('enfants/index.html.twig', [
            'enfants' => $enfantsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="enfants_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enfant = new Enfants();
        $form = $this->createForm(EnfantsType::class, $enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enfant);
            $entityManager->flush();

            return $this->redirectToRoute('enfants_index');
        }

        return $this->render('enfants/new.html.twig', [
            'enfant' => $enfant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enfants_show", methods={"GET"})
     */
    public function show(Enfants $enfant): Response
    {
        return $this->render('enfants/show.html.twig', [
            'enfant' => $enfant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="enfants_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enfants $enfant): Response
    {
        $form = $this->createForm(EnfantsType::class, $enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enfants_index');
        }

        return $this->render('enfants/edit.html.twig', [
            'enfant' => $enfant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enfants_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Enfants $enfant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enfant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enfant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('enfants_index');
    }
}

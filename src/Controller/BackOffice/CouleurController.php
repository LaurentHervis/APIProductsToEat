<?php

namespace App\Controller\BackOffice;

use App\Entity\Couleur;
use App\Form\CouleurType;
use App\Repository\CouleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/couleur")
 */
class CouleurController extends AbstractController
{
    /**
     * @Route("/", name="back_office_couleur_index", methods={"GET"})
     */
    public function index(CouleurRepository $couleurRepository): Response
    {
        return $this->render('couleur/index.html.twig', [
            'couleurs' => $couleurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_office_couleur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CouleurRepository $couleurRepository): Response
    {
        $couleur = new Couleur();
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couleurRepository->add($couleur, true);

            return $this->redirectToRoute('back_office_couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('couleur/new.html.twig', [
            'couleur' => $couleur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_office_couleur_show", methods={"GET"})
     */
    public function show(Couleur $couleur): Response
    {
        return $this->render('couleur/show.html.twig', [
            'couleur' => $couleur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_office_couleur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Couleur $couleur, CouleurRepository $couleurRepository): Response
    {
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couleurRepository->add($couleur, true);

            return $this->redirectToRoute('back_office_couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('couleur/edit.html.twig', [
            'couleur' => $couleur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_office_couleur_delete", methods={"POST"})
     */
    public function delete(Request $request, Couleur $couleur, CouleurRepository $couleurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$couleur->getId(), $request->request->get('_token'))) {
            $couleurRepository->remove($couleur, true);
        }

        return $this->redirectToRoute('back_office_couleur_index', [], Response::HTTP_SEE_OTHER);
    }
}

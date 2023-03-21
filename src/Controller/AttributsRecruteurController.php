<?php

namespace App\Controller;

use App\Entity\AttributsRecruteur;
use App\Form\AttributsRecruteurType;
use App\Repository\AttributsRecruteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/attributs/recruteur')]
class AttributsRecruteurController extends AbstractController
{
    #[Route('/', name: 'app_attributs_recruteur_index', methods: ['GET'])]
    public function index(AttributsRecruteurRepository $attributsRecruteurRepository): Response
    {
        return $this->render('attributs_recruteur/index.html.twig', [
            'attributs_recruteurs' => $attributsRecruteurRepository->findAll(),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/new', name: 'app_attributs_recruteur_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_RECRUTEUR', message: 'No access!')]
    public function new(Request $request, AttributsRecruteurRepository $attributsRecruteurRepository): Response
    {
        $attributsRecruteur = new AttributsRecruteur();
        $form = $this->createForm(AttributsRecruteurType::class, $attributsRecruteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributsRecruteurRepository->save($attributsRecruteur, true);

            return $this->redirectToRoute('app_attributs_recruteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attributs_recruteur/new.html.twig', [
            'attributs_recruteur' => $attributsRecruteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attributs_recruteur_show', methods: ['GET'])]
    public function show(AttributsRecruteur $attributsRecruteur): Response
    {
        return $this->render('attributs_recruteur/show.html.twig', [
            'attributs_recruteur' => $attributsRecruteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_attributs_recruteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AttributsRecruteur $attributsRecruteur, AttributsRecruteurRepository $attributsRecruteurRepository): Response
    {
        $form = $this->createForm(AttributsRecruteurType::class, $attributsRecruteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributsRecruteurRepository->save($attributsRecruteur, true);

            return $this->redirectToRoute('app_attributs_recruteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attributs_recruteur/edit.html.twig', [
            'attributs_recruteur' => $attributsRecruteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attributs_recruteur_delete', methods: ['POST'])]
    public function delete(Request $request, AttributsRecruteur $attributsRecruteur, AttributsRecruteurRepository $attributsRecruteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributsRecruteur->getId(), $request->request->get('_token'))) {
            $attributsRecruteurRepository->remove($attributsRecruteur, true);
        }

        return $this->redirectToRoute('app_attributs_recruteur_index', [], Response::HTTP_SEE_OTHER);
    }
}

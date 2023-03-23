<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AnnonceController extends AbstractController
{
    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
            'user' => $this->getUser()
        ]);
    }

    #[Route('/annonce/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_RECRUTEUR', message: 'No access!')]
    public function new(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setUserId($this->getUser());
            $annonce->setActif(false);
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/annonce/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/annonce/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/annonce/{id}/add/candidate', name: 'app_annonce_add_candidate', methods: ['GET', 'POST'])]
    public function addCandidate(Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        //$annonce->addCandidatureId();
        //$annonce->getUserId();
        
        //$annonce->$this->getUser();
        //$annonceRepository->save($annonce, true);

        return $this->redirectToRoute('app_candidature_new', array('annonceId' => $annonce->getId()));
    }
    
    #[Route('/annonce/{id}/activate', name: 'app_annonce_activate', methods: ['GET', 'POST'])]
    public function activate(Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $annonce->setActif(true);
        $annonceRepository->save($annonce, true);

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/annonce/{id}/deactivate', name: 'app_annonce_deactivate', methods: ['GET', 'POST'])]
    public function deactivate(Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $annonce->setActif(false);
        $annonceRepository->save($annonce, true);

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/annonce/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }
}

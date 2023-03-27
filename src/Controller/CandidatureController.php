<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Annonce;
use App\Form\CandidatureType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/', name: 'app_candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/new/{annonceId}', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CANDIDAT', message: 'No access!')]
    public function new($annonceId ,AnnonceRepository $annonceRepository, Request $request, CandidatureRepository $candidatureRepository): Response
    {
        $candidature = new Candidature();
        
        $candidature->setUserId($this->getUser());
        $annonce = $annonceRepository->find($annonceId);
        $candidature->setIsValid(False);
        $annonce->addCandidatureId($candidature);
        $annonceRepository->save($annonce, true);
        
        $candidature->setAnnonceId($annonce);
        $candidatureRepository->save($candidature, true);
        
        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_CONSULTANT', message: 'No access!')]
    #[Route('/candidature/{id}/activate', name: 'app_candidature_activate', methods: ['GET', 'POST'])]
    public function activate(int $id, Candidature $candidature, CandidatureRepository $candidatureRepository,AnnonceRepository $annonceRepository, UserRepository $userRepository): Response
    {
        $candidature->setIsValid(true);
        $candidatureRepository->save($candidature, true);

        $annonceId= $candidatureRepository->find($id)->getAnnonceId(); 
        $annonce = $annonceRepository->find($annonceId);
        
        $userIdRecruteur = $annonce->getUserId();
        $userMailRecruteur = $userRepository->find($userIdRecruteur);
        
        $candidat = $candidatureRepository->find($id)->getUserId(); 
        //dump($candidat);
        //die();
        
        return $this->redirectToRoute('app_mailer', array('userMailRecruteur' => $userMailRecruteur, 'candidat'=> $candidat), Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{id}', name: 'app_candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidatureRepository->save($candidature, true);

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidature_delete', methods: ['POST'])]
    public function delete(Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $candidatureRepository->remove($candidature, true);
        }

        return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
    }
}

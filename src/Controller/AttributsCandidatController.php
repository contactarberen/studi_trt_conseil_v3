<?php

namespace App\Controller;

use App\Entity\AttributsCandidat;
use App\Form\AttributsCandidatType;
use App\Repository\AttributsCandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/attributs/candidat')]
class AttributsCandidatController extends AbstractController
{
    #[Route('/', name: 'app_attributs_candidat_index', methods: ['GET'])]
    public function index(AttributsCandidatRepository $attributsCandidatRepository): Response
    {
        return $this->render('attributs_candidat/index.html.twig', [
            'attributs_candidats' => $attributsCandidatRepository->findAll(),
            'user' => $this->getUser(),
        ]);
    }
    
    #[Route('/new', name: 'app_attributs_candidat_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CANDIDAT', message: 'No access!')]
    public function new(Request $request, AttributsCandidatRepository $attributsCandidatRepository, SluggerInterface $slugger): Response
    {
        $attributsCandidat = new AttributsCandidat();
        $attributsCandidat->setUserId($this->getUser());
        $form = $this->createForm(AttributsCandidatType::class, $attributsCandidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cv = $form->get('cv')->getData();
            $image = $form->get('image')->getData();
           
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('image_uploads'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dump($e);
                }
                $attributsCandidat->setImage($newFilename);
            }
            
            if ($cv) {
                $originalFilename = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cv->guessExtension();

                // Move the file to the directory where cv are stored
                try {
                    $cv->move(
                        $this->getParameter('cv_uploads'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    dump($e);
                }

                $attributsCandidat->setCv($newFilename);
            }

            $attributsCandidatRepository->save($attributsCandidat, true);

            return $this->redirectToRoute('app_attributs_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('attributs_candidat/new.html.twig', [
            'attributs_candidat' => $attributsCandidat,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_attributs_candidat_show', methods: ['GET'])]
    public function show(AttributsCandidat $attributsCandidat): Response
    {
        return $this->render('attributs_candidat/show.html.twig', [
            'attributs_candidat' => $attributsCandidat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_attributs_candidat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AttributsCandidat $attributsCandidat, AttributsCandidatRepository $attributsCandidatRepository): Response
    {
        $form = $this->createForm(AttributsCandidatType::class, $attributsCandidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributsCandidatRepository->save($attributsCandidat, true);

            return $this->redirectToRoute('app_attributs_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('attributs_candidat/edit.html.twig', [
            'attributs_candidat' => $attributsCandidat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attributs_candidat_delete', methods: ['POST'])]
    public function delete(Request $request, AttributsCandidat $attributsCandidat, AttributsCandidatRepository $attributsCandidatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributsCandidat->getId(), $request->request->get('_token'))) {
            $attributsCandidatRepository->remove($attributsCandidat, true);
        }

        return $this->redirectToRoute('app_attributs_candidat_index', [], Response::HTTP_SEE_OTHER);
    }
}

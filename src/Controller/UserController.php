<?php

namespace App\Controller;

use App\Entity\AttributsCandidat;
use App\Entity\AttributsRecruteur;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    /**
    * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CONSULTANT')")
    */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'userConnected' => $this->getUser()
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        $user = new User($userPasswordHasher);
        $attributsCandidat = new AttributsCandidat;
        $attributsRecruteur = new AttributsRecruteur;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getDisplayedRoleId() == "Candidat") {
                $user->setRoles(["ROLE_USER", "ROLE_CANDIDAT"]);
                $user->setActif(False);
                $user->setAttrCandidatId($attributsCandidat);
            }
            if ($user->getDisplayedRoleId() == "Recruteur") {
                $user->setRoles(["ROLE_USER","ROLE_RECRUTEUR"]);
                $user->setActif(False);
                $user->setAttrRecruteurId($attributsRecruteur);
            }
            
            if ($this->isGranted('ROLE_ADMIN')){
                $user->setRoles(["ROLE_CONSULTANT"]);
                $user->setActif(true);
            }
            
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'attributs_candidat' => $attributsCandidat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/activate', name: 'app_user_activate', methods: ['GET', 'POST'])]
    public function activate(User $user, UserRepository $userRepository): Response
    {
        $user->setActif(true);
        $userRepository->save($user, true);

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/deactivate', name: 'app_user_deactivate', methods: ['GET', 'POST'])]
    public function deactivate(User $user, UserRepository $userRepository): Response
    {
        $user->setActif(false);
        $userRepository->save($user, true);

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}

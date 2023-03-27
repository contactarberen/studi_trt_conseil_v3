<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
//use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\AttributsCandidatRepository;
use App\Entity\User;
use App\Entity\AttributsCandidat;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class MailerController extends AbstractController
{
    #[Route('/mailer/{userMailRecruteur}/{candidat}', name: 'app_mailer', methods: ['GET', 'POST'])]
    public function index(MailerInterface $mailer, UserRepository $userRepository, AttributsCandidatRepository $attributsCandidatRepository,string $userMailRecruteur, string $candidat):Response
    {
        $user = $userRepository->findOneBy(array('email' => $candidat));
        
        $allAttrCandidat = $attributsCandidatRepository->findAll();
        $attributsCandidat = new AttributsCandidat;
        foreach ($allAttrCandidat as $val) {
            if ($val->getUserId()->getId() == $user->getId())
            {
                $attributsCandidat = $val;
                dump($attributsCandidat);
                   
            }
        }
        $email = (new TemplatedEmail())
            ->from('contact@trt-conseil.com')
            ->to($userMailRecruteur)
            ->subject('Nouvelle Candidature -'.(new \DateTime())->format('m Y'))
            ->addPart(new DataPart(new File('uploads/cv/' . $attributsCandidat->getCv(), 'cv.pdf')))
            //->addPart(new DataPart(new File('uploads/cv/ep-6421ff725fb38.pdf', 'cv.pdf')))
            ->htmlTemplate('envoimail.html.twig')
            ->context([
                'nom' => [
                    $attributsCandidat->getNom(),
                    $attributsCandidat->getPrenom(),
                ],
            ]);
            
        $mailer->send($email);
        return $this->render('mailer/index.html.twig', []);
    }
}

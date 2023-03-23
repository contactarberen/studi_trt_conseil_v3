<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\User;
use App\Entity\DiplayedRole;
use App\Entity\TypeContrat;
use App\Form\AnnonceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User($this->passwordHasher);
        $user->setEmail("admin@trt-conseil.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $user->setActif(true);
        $displayedRole1 = new DiplayedRole();
        $displayedRole1->setNom("Recruteur");
        $displayedRole2 = new DiplayedRole();
        $displayedRole2->setNom("Candidat");  
        
        $typeContrat1 = new TypeContrat();
        $typeContrat1->setNomContrat("CDI");
        $typeContrat2 = new TypeContrat();
        $typeContrat2->setNomContrat("CDD");
        $typeContrat3 = new TypeContrat();
        $typeContrat3->setNomContrat("Freelance");  
        $typeContrat4 = new TypeContrat();
        $typeContrat4->setNomContrat("Apprentissage");  

        // création bdd optionnel
        $cand1 = new User($this->passwordHasher);
        $cand1->setEmail("cand1@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_CANDIDAT"]);
        $cand1->setActif(true);
        $cand2 = new User($this->passwordHasher);
        $cand2->setEmail("cand2@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_CANDIDAT"]);
        $cand2->setActif(true);
        $cand3 = new User($this->passwordHasher);
        $cand3->setEmail("cand3@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_CANDIDAT"]);
        $cand3->setActif(true);
        $recrut1 = new User($this->passwordHasher);
        $recrut1->setEmail("recrut1@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_RECRUTEUR"]);
        $recrut1->setActif(true);
        $recrut2 = new User($this->passwordHasher);
        $recrut2->setEmail("recrut2@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_RECRUTEUR"]);
        $recrut2->setActif(true);
        $recrut3 = new User($this->passwordHasher);
        $recrut3->setEmail("recrut3@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_RECRUTEUR"]);
        $recrut3->setActif(true);
        $consul1 = new User($this->passwordHasher);
        $consul1->setEmail("consultant1@studi.fr")->setPassword("321")->setRoles(["ROLE_USER", "ROLE_CONSULTANT"]);
        $consul1->setActif(true);

        $annonce1 = new Annonce();
        $annonce1->setIntitulePoste("Développeur frontend")->setLieuTravail("Argenteuil")->setDescription("Expérience exigé de 5 ans.");
        $annonce1->setHoraires("8h00 - 17h00")->setSalaire(4500)->setIdTypeContrat($typeContrat1)->setUserId($recrut1);
        $annonce1->setActif(true);
        $annonce2 = new Annonce();
        $annonce2->setIntitulePoste("Développeur backend")->setLieuTravail("Colombes")->setDescription("Expérience exigé de 10 ans.");
        $annonce2->setHoraires("Full Remote")->setSalaire(3850)->setActif(true)->setIdTypeContrat($typeContrat3)->setUserId($recrut2);
        $annonce3 = new Annonce();
        $annonce3->setIntitulePoste("Administrateur réseaux")->setLieuTravail("Argenteuil")->setDescription("Apprentissage. avoir moins de 24 ans.");
        $annonce3->setHoraires("8h00 - 17h00")->setSalaire(4500)->setActif(true)->setIdTypeContrat($typeContrat4)->setUserId($recrut2);
        $annonce4 = new Annonce();
        $annonce4->setIntitulePoste("Développeur fullstack")->setLieuTravail("Strasbourg")->setDescription("Expérience exigé de 5 ans.");
        $annonce4->setHoraires("8h00 - 17h00")->setSalaire(4500)->setActif(true)->setIdTypeContrat($typeContrat1)->setUserId($recrut1);
        $annonce5 = new Annonce();
        $annonce5->setIntitulePoste("Ingénieur Téléphonie")->setLieuTravail("Narbonne")->setDescription("pas d'expérience.");
        $annonce5->setHoraires("9h00 - 16h00")->setSalaire(6500)->setActif(true)->setIdTypeContrat($typeContrat2)->setUserId($recrut3);
  
        $manager->persist($user);
        $manager->persist($displayedRole1);
        $manager->persist($displayedRole2);
        $manager->persist($typeContrat1);
        $manager->persist($typeContrat2);
        $manager->persist($typeContrat3);
        $manager->persist($typeContrat4);
        //creation bdd optionnel
        $manager->persist($cand1);
        $manager->persist($cand2);
        $manager->persist($cand3);
        $manager->persist($recrut1);
        $manager->persist($recrut2);
        $manager->persist($recrut3);
        $manager->persist($consul1);
        $manager->persist($annonce1);
        $manager->persist($annonce2);
        $manager->persist($annonce3);
        $manager->persist($annonce4);
        $manager->persist($annonce5);
        
        $manager->flush();
    }    
}

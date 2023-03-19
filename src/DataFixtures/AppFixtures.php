<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\DiplayedRole;
use App\Entity\TypeContrat;
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
  
        $manager->persist($user);
        $manager->persist($displayedRole1);
        $manager->persist($displayedRole2);
        $manager->persist($typeContrat1);
        $manager->persist($typeContrat2);
        $manager->persist($typeContrat3);
        $manager->persist($typeContrat4);
        $manager->flush();
    }    
}

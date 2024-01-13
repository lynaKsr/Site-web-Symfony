<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/securitytest', name: '_securitytest')]
class SecurityTestController extends AbstractController
{
   #[Route('/addusers', name: '_addusers')]
    public function addUsersAction(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
   {

       $user = new Utilisateur();
       $user
           ->setLogin('rita')
           ->setNom('Zrour ')
           ->setPrenom('Rita')
           ->setDateDeNaissance(new \DateTimeImmutable("2/11/1998"))
           ->setIsAdmin(false)
           ->setRoles(['ROLE_CLIENT']);
       $hashedPassword = $passwordHasher->hashPassword($user, 'atir');
       $user->setPassword($hashedPassword);
       $em->persist($user);

       $user = new Utilisateur();
       $user
           ->setLogin('gilles')
           ->setNom('Subrenat ')
           ->setPrenom('Gilles')
           ->setDateDeNaissance(new \DateTimeImmutable("2/11/1998"))
           ->setIsAdmin(true)
           ->setRoles(['ROLE_ADMIN']);
       $hashedPassword = $passwordHasher->hashPassword($user, 'sellig');
       $user->setPassword($hashedPassword);
       $em->persist($user);

       $user = new Utilisateur();
       $user
           ->setLogin('sadmin')
           ->setNom('Kessouri ')
           ->setPrenom('Lyna')
           ->setDateDeNaissance(new \DateTimeImmutable("3/04/2003"))
           ->setIsAdmin(false)
           ->setRoles(['ROLE_SADMIN']);
       $hashedPassword = $passwordHasher->hashPassword($user, 'nimdas');
       $user->setPassword($hashedPassword);
       $em->persist($user);

       $user = new Utilisateur();
       $user
           ->setLogin('Simon')
           ->setNom('Merci ')
           ->setPrenom('Simon')
           ->setDateDeNaissance(new \DateTimeImmutable("2/11/1889"))
           ->setIsAdmin(false)
           ->setRoles(['ROLE_CLIENT']);
       $hashedPassword = $passwordHasher->hashPassword($user, 'nomis');
       $user->setPassword($hashedPassword);
       $em->persist($user);

       $em->flush();

       return new Response('<body></body>');
   }
}

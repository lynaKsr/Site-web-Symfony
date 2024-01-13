<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Container2lXXCSZ\getCache_SecurityExpressionLanguageService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/Utilisateur', name: 'utilisateur')]
class UtilisateurController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/list', name: '_list')]
    public function allAction(EntityManagerInterface $em): Response
    {
        $utilisateurRepository = $em->getRepository(Utilisateur::class);
        $utilisateurs = $utilisateurRepository->findAll();

        $args = array(
            'utilisateurs' => $utilisateurs,
            'utilisateurNow' => $this->getUser(),
        );

        return $this->render('Utilisateur/list.html.twig', $args);
    }

    #[Route('/supprimer/{id}', name:'_supprimer')]
    public function supprimerAction(EntityManagerInterface $em, Utilisateur $user) : Response
    {
        $userNow = $this->getUser();
        $panierRepository = $em->getRepository(Panier::class);
        if($this->isGranted('ROLE_ADMIN') || $user === $userNow)
        {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ce compte');
            return $this->redirectToRoute('utilisateur_list');
        }
        $paniers = $panierRepository->findBy(['utilisateur' => $user]);

        foreach ($paniers as $panier) {
            $produit = $panier->getProduit();
            $produit->setQuantite($produit->getQuantite()+$panier->getQuantite());
            $em->persist($produit);
            $em->remove($panier);
        }
        $em->persist($user);

        $em->remove($user);

        $this->addFlash('info', 'utilisateur supprimé');

        return $this->redirectToRoute('utilisateur_list');
    }
    #[Route('/editer/{id}', name:'_editer')]
    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security(
        "is_granted('ROLE_CLIENT') or is_granted('ROLE_ADMIN')"
    )]
    public function editerAction(EntityManagerInterface $em, Utilisateur $user, Request $request, UserPasswordHasherInterface $passwordHasher) : Response
    {
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->add('modifier', SubmitType::class, ['label' => 'modifier profil']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $password = $user->getPassword();

            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $em->flush();

            $this->addFlash('success', 'Informations modifiées');
        }
        else {
            if($form->isSubmitted())
                $this->addFlash('erreur', 'erreur pendant l\'edition de votre profil');
        }
        return $this->render('Utilisateur/edit.html.twig', ['EditionForm' => $form]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/security', name: 'security')]
class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: '_login')]
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



    #[Route('/inscription', name: '_inscription')]
    public function inscriptionAction(Request $request,UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em) : Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->add('send', SubmitType::class, ['label' => 's\'inscrire']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setIsAdmin(false);

            $password = $user->getPassword();

            $user->setPassword($passwordHasher->hashPassword($user, $password));

            $em->persist($user);
            $em->flush();
            $this->addFlash('succés', 'Confirmation de votre inscription');

            return $this->redirectToRoute('accueil_index');
        }
        else
        {
            if ($form->isSubmitted()) {
                $this->addFlash('erreur', 'Erreur lors de votre inscription');
            }
        }
        $args =array(
            'formInscription' => $form->createView(),
        );

        return $this->render('Security/inscription.html.twig',$args);

    }




    #[Route(path: '/logout', name: '_logout')]
    public function logoutAction(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

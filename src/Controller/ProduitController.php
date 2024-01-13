<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/produit', name: 'produit')]
class ProduitController extends AbstractController
{

    #[Route('/list', name: '_list')]
    #[IsGranted('ROLE_CLIENT')]
    #[IsGranted('ROLE_ADMIN')]
    public function listAction(EntityManagerInterface $em, Request $request) : Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $produits = $produitRepository->findAll();

        $panierRepository = $em->getRepository(Panier::class);
        $panier = $panierRepository->find($this->getUser());

        $forms = [];

        foreach ($produits as $produit) {
            // panier qui contient le produit
            $produitInPanier = $panierRepository->find($produit);

            // produits présents dans le panier (min)
            if(is_null($panier))
            {
                $min = 0;
            }
            else $min = $panier->getQuantite();

            // produits présents en stock (max)
            $max = $produit->getQuantiteStock();

            $form = $this->createFormBuilder()
                ->add('choix', ChoiceType::class, [
                    'label' => 'choix',
                    'choices' => range($min, $max)]
                    )
                ->getForm();

            $form->handlerequest($request);
            $forms[$produit->getId()] = $form->createView();


            if ($form->isSubmitted() && $form->isValid()) {
                $choix = $form->get('choix')->getData();

                if(!is_null($produitInPanier)) {
                    $produitInPanier->setQuantite($min + $choix);
                    $quantitePanier = $produitInPanier->getQuantite();

                    if($quantitePanier === 0)
                        $em->remove($produitInPanier);
                    else
                        if($choix > 0) {
                            $nouveauPanier = new Panier();
                            $nouveauPanier
                                ->setQuantite($choix);
                            $em->persist($panier);
                            $produit->addPanier($nouveauPanier);
                        }
                }
                $produit->setQuantiteStock($max - $choix);
                $em->flush();
                $this->addFlash('info', 'ajout produit réussi');

            }

        }
        $args = array('produits' =>$produits,
        'forms' => $forms,);
            return $this->render('Produit/list.html.twig', $args);

    }


    #[Route('/add', name: '_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function addAction(EntityManagerInterface $em, Request $request) : Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('send', SubmitType::class, ['label' => 'add produit']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('info', 'ajout produit réussi');
            return $this->redirectToRoute('accueil_index');
        }

        if($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout de produit incorrect');

        $args =array(
            'myform' => $form->createView(),
        );
        return $this->render('Produit/add.html.twig', $args);
    }
}

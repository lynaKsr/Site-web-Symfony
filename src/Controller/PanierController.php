<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/panier', name: 'panier')]
#[IsGranted('ROLE_CLIENT')]
class PanierController extends AbstractController
{
    #[Route('/', name: '')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $produitRepository = $em->getRepository(Produit::class);
        $produits = $produitRepository->findAll();

        $panierRepository = $em->getRepository(Panier::class);
        $panierLivres = $panierRepository->find($this->getUser());

        $prixTotale = 0;
        $quantiteTotale = 0;

        return $this->render('Panier/list.html.twig', [
            'panierLivres' => $panierLivres,
            'produits' => $produits,
            'prixTotal' => $prixTotale,
            'quantiteTotale' => $quantiteTotale,
        ]);
    }


    #[Route('/supprimer/{id}',
            name:'_supprimer',
            requirements: ['id' => '[1-9]\d*']
    )]
    public function supprimerAction(EntityManagerInterface $em, Panier $id) : Response
    {
        $panierRepository = $em->getRepository(Panier::class);
        $produitRepository = $em->getRepository(Produit::class);
        $paniers = $panierRepository->find($id);
        $produit = $produitRepository->find($paniers->getProduitId());

        $quantitePanier = $paniers->getQuantite();
        $quantiteProduit = $produit->getStock();

        $produit->setStock($quantiteProduit+$quantitePanier);

        $em->persist($produit);
        $em->remove($paniers);
        $em->flush();

        $this->addFlash('success', 'livre supprimé');

        return $this->redirectToRoute('panier');
    }

    #[Route('/vider', name: '_vider')]
    public function viderAction(EntityManagerInterface $em) {
        $user = $this->getUser();
        $panierRepository = $em->getRepository(Panier::class);
        $paniers = $panierRepository->findby(['user'=>$user]);

        foreach ($paniers as $panier) {
            $produit = $panier->getProduit();
            $produit->setQuantite($produit->getStock()+ $panier->getQuantite());

            $em->persist($produit);
            $em->remove($panier);
        }
        $em->flush();

        $this->addFlash('success', 'Panier vidé');

        return $this->redirectToRoute('panier');

    }

}

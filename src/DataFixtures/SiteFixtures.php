<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SiteFixtures extends Fixture
{
    public function load(ObjectManager $em): void
    {
        $produit1 = new Produit();
        $produit1
            ->setLibelle('l\'ecrivain')
            ->setPrixUnitaire(9)
            ->setQuantiteStock(6);
        $em->persist($produit1);

        $produit2 = new Produit();
        $produit2
            ->setLibelle('la fille de papier')
            ->setPrixUnitaire(10)
            ->setQuantiteStock(5);
        $em->persist($produit2);

        $produit3 = new Produit();
        $produit3
            ->setLibelle('l alchimiste')
            ->setPrixUnitaire(12)
            ->setQuantiteStock(3);
        $em->persist($produit3);

        $em->flush();



    }
}

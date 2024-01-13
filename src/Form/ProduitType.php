<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',
                TextType::class,
                [
                    'label' => 'titre du livre : ',
                    'required' => true,
                ])
            ->add('prixUnitaire',
                NumberType::class,
                [
                    'label' => 'prix : ',
                    'required' => true,
                ])
            ->add('quantiteStock',
                IntegerType::class,
                [
                    'label' => 'quantité en stock : ',
                    'required' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

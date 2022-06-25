<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Couleur;
use App\Entity\Month;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('averagePrice')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                // Choix multiple
                'multiple' => false,
                // Des boutons radios
                'expanded' => true,
            ])
            ->add('months', EntityType::class, [
                'class' => Month::class,
                'choice_label' => 'name',
                // Choix multiple
                'multiple' => true,
                // Des boutons radios
                'expanded' => true,
            ])
            ->add('couleurs', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'name',
                // Choix multiple
                'multiple' => true,
                // Des boutons radios
                'expanded' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Souche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SoucheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('nomPresouche',  TextType::class, ['required' => false])
            ->add('espece', TextType::class)
            ->add('sousEspeces', TextType::class, ['required' => false])
            ->add('genre', TextType::class)
            ->add('biovar', TextType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Souche::class,
        ]);
    }
}

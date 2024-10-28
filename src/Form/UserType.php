<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false, // Ne pas lier ce champ directement à l'entité User
                'required' => false,
                'label' => 'Nouveau mot de passe',
            ])
            ->add('role', CheckboxType::class, [
                'label' => 'Administrateur',
                'required' => false, // Facultatif
                'mapped' => true, // Ne pas lier ce champ directement à l'entité User
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

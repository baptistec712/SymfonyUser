<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;

class UserType extends AbstractType
{

    public function __construct(
        private Security $security,
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var App/Entity/User $this **/
        $userId = $this->security->getUser()->getId();
        $userRole = $this->security->getUser()->getRoles();

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false, // Ne pas lier ce champ directement à l'entité User
                'required' => false,
                'label' => 'Nouveau mot de passe',
            ]);


        if ($userId != $builder->getData()->getId()) {
            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Administrateur' => 'ROLE_ADMIN',
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'required' => false,
                    'mapped' => true,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'current_user' => null, // Ajoutez l'option 'current_user' ici
        ]);
    }
}

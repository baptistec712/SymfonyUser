<?php

// src/Controller/UserController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/compte', name: 'app_compte', methods: ['GET', 'POST'])]
    public function displayCompte(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du mot de passe si un nouveau est fourni
            $newPassword = $form->get('password')->getData();
            if ($newPassword) {
                $encodedPassword = $passwordEncoder->hashPassword($user, $newPassword);
                $user->setPassword($encodedPassword);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été mis à jour.');

            return $this->redirectToRoute('app_compte');
        }

        return $this->render('user/compte.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}

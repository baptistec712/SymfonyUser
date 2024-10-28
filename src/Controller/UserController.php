<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken; // Import the CsrfToken class
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('User/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/{id}/edit', name: 'app_user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // Créer le formulaire
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer la valeur de la case à cocher pour le rôle
            $role = $form->get('role')->getData();
            $user->setRole($role); // Met à jour le champ role dans l'entité User


            $password = $form->get('password')->getData();

            // Vérifier si un nouveau mot de passe est saisi
            if ($password) {
                // Encode et met à jour le mot de passe de l'utilisateur
                $user->setPassword($userPasswordHasher->hashPassword($user, $password));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users');
        }

        // Rendre le formulaire dans la vue
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/users/{id}/delete', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        //pas compris il faut que je me renseigne
        $submittedToken = $request->request->get('_token');
        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete' . $user->getId(), $submittedToken))) {
            // Remove the user from the database
            $entityManager->remove($user);
            $entityManager->flush();

            //ajoute un message
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        }

        return $this->redirectToRoute('app_users');
    }

    #[Route('/users/new', name: 'app_user_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // Créer une nouvelle instance de l'entité User
        $user = new User();

        // Créer un formulaire lié à l'entité User
        $form = $this->createForm(UserType::class, $user);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le mot de passe saisi
            $password = $form->get('password')->getData();

            // Vérifier si un mot de passe est fourni
            if ($password) {
                // Encoder le mot de passe
                $user->setPassword($userPasswordHasher->hashPassword($user, $password));
            }

            // Persister la nouvelle entité dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Ajouter un message de confirmation
            $this->addFlash('success', 'Utilisateur ajouté avec succès.');

            // Rediriger vers la liste des utilisateurs
            return $this->redirectToRoute('app_users');
        }

        // Rendre le formulaire dans la vue
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

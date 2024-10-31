<?php

namespace App\Controller;

use App\Form\BacteriophageType;
use App\Entity\Bacteriophage;
use App\Repository\BacteriophageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BacteriophageController extends AbstractController
{
    #[Route('/bacteriophages', name: 'app_bacteriophage', methods: ['GET'])]
    public function index(BacteriophageRepository $bacteriophageRepository): Response
    {
        return $this->render('bacteriophage/index.html.twig', [
            'bacteriophages' => $bacteriophageRepository->findAll(),
        ]);
    }

    #[Route('/bacteriophage/new', name: 'app_bacteriophage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bacteriophage = new Bacteriophage();
        $form = $this->createForm(BacteriophageType::class, $bacteriophage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bacteriophage);
            $entityManager->flush();

            return $this->redirectToRoute('app_bacteriophage');
        }

        return $this->render('bacteriophage/new.html.twig', [
            'bacteriophage' => $bacteriophage,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/bacteriophage/{id}/edit', name: 'app_bacteriophage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bacteriophage $bacteriophage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BacteriophageType::class, $bacteriophage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bacteriophage');
        }

        return $this->render('bacteriophage/edit.html.twig', [
            'bacteriophage' => $bacteriophage,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/bacteriophage/{id}/delete', name: 'app_bacteriophage_delete', methods: ['POST'])]
    public function delete(Request $request, Bacteriophage $bacteriophage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bacteriophage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bacteriophage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bacteriophage');
    }
}
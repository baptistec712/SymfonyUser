<?php

namespace App\Controller;

use App\Form\ConsortiaType;
use App\Entity\Consortia;
use App\Repository\ConsortiaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ConsortiaController extends AbstractController
{
    #[Route('/consortias', name: 'app_consortia', methods: ['GET'])]
    public function index(ConsortiaRepository $consortiaRepository): Response
    {
        return $this->render('consortia/index.html.twig', [
            'consortias' => $consortiaRepository->findAll(),
        ]);
    }

    #[Route('/consortia/new', name: 'app_consortia_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consortia = new Consortia();
        $form = $this->createForm(ConsortiaType::class, $consortia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consortia);
            $entityManager->flush();

            return $this->redirectToRoute('app_consortia');
        }

        return $this->render('consortia/new.html.twig', [
            'consortia' => $consortia,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/Consortia/{id}/edit', name: 'app_consortia_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consortia $consortia, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsortiaType::class, $consortia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consortia');
        }

        return $this->render('consortia/edit.html.twig', [
            'consortia' => $consortia,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/consortia/{id}/delete', name: 'app_consortia_delete', methods: ['POST'])]
    public function delete(Request $request, Consortia $consortia, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $consortia->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consortia);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consortia');
    }
}
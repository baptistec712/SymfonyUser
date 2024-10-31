<?php

namespace App\Controller;

use App\Entity\Souche;
use App\Form\SoucheType;
use App\Repository\SoucheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoucheController extends AbstractController
{
    #[Route('/souches', name: 'app_souche', methods: ['GET'])]
    public function index(SoucheRepository $soucheRepository): Response
    {
        return $this->render('souche/index.html.twig', [
            'souches' => $soucheRepository->findAll(),
        ]);
    }

    #[Route('/souche/new', name: 'app_souche_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $souche = new Souche();
        $form = $this->createForm(SoucheType::class, $souche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($souche);
            $entityManager->flush();

            return $this->redirectToRoute('app_souche');
        }

        return $this->render('souche/new.html.twig', [
            'souche' => $souche,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/souche/{id}/edit', name: 'app_souche_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Souche $souche, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SoucheType::class, $souche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_souche');
        }

        return $this->render('souche/edit.html.twig', [
            'souche' => $souche,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/souche/{id}/delete', name: 'app_souche_delete', methods: ['POST'])]
    public function delete(Request $request, Souche $souche, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $souche->getId(), $request->request->get('_token'))) {
            $entityManager->remove($souche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_souche');
    }
}
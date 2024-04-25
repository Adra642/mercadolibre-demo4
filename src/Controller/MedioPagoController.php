<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace App\Controller;

use App\Entity\MedioPago;
use App\Form\MedioPagoType;
use App\Repository\MedioPagoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/medio/pago')]
class MedioPagoController extends AbstractController
{
    #[Route('/', name: 'app_medio_pago_index', methods: ['GET'])]
    public function index(MedioPagoRepository $medioPagoRepository): Response
    {
        return $this->render('medio_pago/index.html.twig', [
            'medio_pagos' => $medioPagoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medio_pago_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $medioPago = new MedioPago();
        $form = $this->createForm(MedioPagoType::class, $medioPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medioPago);
            $entityManager->flush();

            return $this->redirectToRoute('app_medio_pago_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('medio_pago/new.html.twig', [
            'medio_pago' => $medioPago,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medio_pago_show', methods: ['GET'])]
    public function show(MedioPago $medioPago): Response
    {
        return $this->render('medio_pago/show.html.twig', [
            'medio_pago' => $medioPago,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medio_pago_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MedioPago $medioPago, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MedioPagoType::class, $medioPago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_medio_pago_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('medio_pago/edit.html.twig', [
            'medio_pago' => $medioPago,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medio_pago_delete', methods: ['POST'])]
    public function delete(Request $request, MedioPago $medioPago, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medioPago->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($medioPago);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_medio_pago_index', [], Response::HTTP_SEE_OTHER);
    }
}

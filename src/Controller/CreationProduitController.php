<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationProduitController extends AbstractController
{
    #[Route('/creationproduit', name: 'creation_produit')]
    public function index(): Response
    {
        return $this->render('creation_produit/index.html.twig', [
            'controller_name' => 'CreationProduitController',
        ]);
    }
}

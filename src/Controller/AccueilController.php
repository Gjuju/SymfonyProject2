<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index( ProduitRepository $produitRepository): Response
    {
        
        $produits = $produitRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            'produits' => $produits,
        ]);
    }
}

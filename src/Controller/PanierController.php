<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier/{id}", name="panier")
     */
   public function Panier(Produit $produit): Response
  {
        return $this->render('panier/panier.html.twig', [
            'produit' => $produit

     ]);
 }
}

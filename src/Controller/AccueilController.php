<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ProduitRepository $produitRepository, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $produitRepository->getProduitPaginator($offset);
        
        return $this->render('accueil/index.html.twig', [
            'produits' => $paginator,
            'previous' => $offset - ProduitRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProduitRepository::PAGINATOR_PER_PAGE),
        ]);
    }



}

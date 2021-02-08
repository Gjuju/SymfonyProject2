<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
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
        //dd($paginator);


        return $this->render('accueil/index.html.twig', [
            'produits' => $paginator,
            'previous' => $offset - ProduitRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProduitRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    /**
     * @Route("/produit/{id}", name="detailpdt")
     */
    public function showProduit( Produit $produit ): Response
    {
        return $this->render('detailsproduit/detailPdt.html.twig', [
            'produit' => $produit
        ]);
    }



    /**
     * @Route("/categories", name="categories")
     */
    public function showCategories(CategorieRepository $categorieRepository, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $categorieRepository->getCategoriesPaginator($offset);
        
        return $this->render('accueil/categories.html.twig', [
            'categories' => $paginator,
            'previous' => $offset - CategorieRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CategorieRepository::PAGINATOR_PER_PAGE),
        ]);
    }



    /**
     * @Route("/categorie/{id}", name="categorie")
     */
    public function showProductsCategories(Categorie $categorie, ProduitRepository $produitRepository, int $id , Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $produitRepository->getCategoriePaginator($id, $offset);
        $nomCategorie = $categorie->getNomCategorie();
        // dd($paginator);
        return $this->render('accueil/categorie.html.twig', [
            'nomCategorie' => $nomCategorie,
            'produits' => $paginator,
            'previous' => $offset - ProduitRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProduitRepository::PAGINATOR_PER_PAGE),
        ]);
    }
}

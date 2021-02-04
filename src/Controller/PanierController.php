<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function Panier(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get('panier', []);
        $panierWithData= [];

        foreach ($panier as $id => $quantite){
            $panierWithData[]= [
                'produit' => $produitRepository->find($panier[$id]),
                'quantite'=> $quantite
            ];
        }

        return $this->render('panier/panier.html.twig', [
            'items'=> $panierWithData
        ]);

    }
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, Request $request){
        $session = $request->getSession();

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id]= 1;
        }
        


        $session->set('panier', $panier);
        dd($session->get('panier'));
    }
}

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
                'produit' => $produitRepository->find($id),
                'quantite'=> $quantite
            ];
        }

        $total=0;

        foreach($panierWithData as $item){
            $totalItem = $item['produit']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }

        return $this->render('panier/panier.html.twig', [
            'items'=> $panierWithData,
            'total' => $total
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



    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session){
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");
    }
}

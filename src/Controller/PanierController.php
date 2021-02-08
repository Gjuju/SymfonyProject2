<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function Panier(PanierRepository $panierRepository)
    {

        /* $listeItems = $panierRepository->findAll(); */
        $listeItems = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);


        $total = 0;
        foreach ($listeItems as $key => $value) {

            $prix = $listeItems[$key]->getProduit()->getPrix() * $listeItems[$key]->getQuantite();
            $total += $prix;
        }


        // dd($listeItems, $total);

        // SELECT * FROM produit JOIN panier ON produit.id=panier.produit_id WHERE panier.utilisateur_id = 43

        /* $panier = $session->get('panier', []);
        $panierWithData = [];


        */
        /* $total = 0;
        foreach ($listeItems as $item) {
            $totalItem = $item['produit']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }  

        dd($listeItems);  */
        return $this->render('panier/panier.html.twig', [
            'items' => $listeItems,
            'total' => $total,
        ]);
    }
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add(Produit $produit, PanierRepository $panierRepository, EntityManagerInterface $entityManagerInterface)
    {

        $repo = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);

        //dd($repo);

        //dd(empty($repo));
        
        $newProduit = true ;
        
        foreach ($repo as $ligne) {

            if ( $ligne->getProduit()->getId() === $produit->getId() ) {

                //dd($panier);

                $ligne->setQuantite($ligne->getQuantite() + 1);

                $entityManagerInterface->persist($ligne);
                $entityManagerInterface->flush();

                return $this->redirectToRoute("accueil");
                $newProduit = false ;
            }   

        };


        if (empty($repo) || $newProduit) {
            $newPanier = new Panier();

            $newPanier->setQuantite(1);
            $newPanier->setUtilisateur($this->getUser());
            $newPanier->setProduit($produit);

            //dd($newPanier);
            $entityManagerInterface->persist($newPanier);
            $entityManagerInterface->flush();
        }
        /* $session = $request->getSession();

        $panier = $session->get('panier', []);
        $session->set('panier', $panier); */






        
        return $this->redirectToRoute("accueil");
    }



    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove(int $id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");
    }
}

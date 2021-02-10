<?php

namespace App\Controller;

use App\Entity\Commande;
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
        $listeItems = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);


        $total = 0;
        foreach ($listeItems as $key => $value) {

            $prix = $listeItems[$key]->getProduit()->getPrix() * $listeItems[$key]->getQuantite();
            $total += $prix;
        }

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
        if( ( !$this->isGranted('ROLE_USER') ) && (!$this->isGranted('ROLE_ADMIN')) ){
            return $this->redirectToRoute("cart_addpasco_panier");
        }

        
        $repo = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);
 
        $newProduit = true;

        foreach ($repo as $ligne) {

            if (($ligne->getProduit()->getId() === $produit->getId())) {

                if ($produit->getStock() <= $ligne->getQuantite()) {
                    $this->addFlash('stock', 'Impossible de rajouter l\'article, il n\'y en a plus en stock');
                    return $this->redirectToRoute("accueil");
                }

                $ligne->setQuantite($ligne->getQuantite() + 1);

                $entityManagerInterface->persist($ligne);
                $entityManagerInterface->flush();

                return $this->redirectToRoute("accueil");
                $newProduit = false;
            }
        };


        if (empty($repo) || $newProduit) {
            $newPanier = new Panier();

            $newPanier->setQuantite(1);
            $newPanier->setUtilisateur($this->getUser());
            $newPanier->setProduit($produit);
            $entityManagerInterface->persist($newPanier);
            $entityManagerInterface->flush();
        }
        return $this->redirectToRoute("accueil");
    }



    /**
     * @Route("/panier/ad/{id}", name="cart_add_fpanier")
     */
    public function addFromPanier(Produit $produit, PanierRepository $panierRepository, EntityManagerInterface $entityManagerInterface)
    {

        $repo = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);

        foreach ($repo as $ligne) {

            if ($ligne->getProduit()->getId() === $produit->getId()) {

                if ($produit->getStock() <= $ligne->getQuantite()) {
                    $this->addFlash('stock', 'Impossible de rajouter l\'article, il n\'y en a plus en stock');
                    return $this->redirectToRoute("panier");
                }

                $ligne->setQuantite($ligne->getQuantite() + 1);

                $entityManagerInterface->persist($ligne);
                $entityManagerInterface->flush();

                return $this->redirectToRoute("panier");
            }
        };

        return $this->redirectToRoute("panier");
    }


    /**
     * @Route("/panierpasco", name="cart_pasco_panier")
     */
    public function panierPasco(SessionInterface $session, ProduitRepository $produitRepository){
        $panier = $session->get('panier', []);

        $panierWithData=[];

        foreach($panier as $id =>$quantite){
            $panierWithData[]= [
                'produit'=>$produitRepository->find($id),
                'quantite'=>$quantite
            ];
        }
        $total = 0;
        foreach($panierWithData as $item){
            $totalItem= $item['produit']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }

        return $this->render('panier/panierpasco.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }




    /**
     * @Route("/panier/adpascof/{id}", name="cart_addpasco_fpanier")
     */
    public function addpascoFromPanier($id, SessionInterface $session, Produit $produit){

        $panier= $session->get('panier', []);
        if ($produit->getStock() <= $panier[$id]) {
            $this->addFlash('stock', 'Impossible de rajouter l\'article, il n\'y en a plus en stock');
            return $this->redirectToRoute("cart_pasco_panier");
        }


        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        
        $session->set('panier', $panier);
        return $this->redirectToRoute("cart_pasco_panier");


    }    

    /**
     * @Route("/panier/adpasco/{id}", name="cart_addpasco_panier")
     */
    public function addpasco($id, SessionInterface $session){

        $panier= $session->get('panier', []);


        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
         $panier[$id]= 1;   
        }
        
        $session->set('panier', $panier);
        return $this->redirectToRoute("accueil");


    }

    /**
     * @Route("/panier/removepaco/{id}", name="cart_removepasco")
     */
    public function removepasco($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_pasco_panier");
    }

    /**
     * @Route("/panier/remvpascof/{id}", name="cart_rmvpasco_fpanier")
     */
    public function rmvpascoFromPanier($id, SessionInterface $session){

        $panier= $session->get('panier', []);


        if(!empty($panier[$id])){
            $panier[$id]--;
        }
        if($panier[$id]<1){
            unset($panier[$id]);
        }
        
        $session->set('panier', $panier);
        return $this->redirectToRoute("cart_pasco_panier");


    }     



    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove(Produit $produit, PanierRepository $panierRepository, EntityManagerInterface $entityManagerInterface)
    {
        $repo = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);

        foreach ($repo as $ligne) {

            if ($ligne->getProduit()->getId() === $produit->getId()) {

                $entityManagerInterface->remove($ligne);
                $entityManagerInterface->flush();
            }
        };

        return $this->redirectToRoute("panier");
    }



    /**
     * @Route("/panier/remve/{id}", name="cart_remove_fpanier")
     */
    public function removeFromPanier(Produit $produit, PanierRepository $panierRepository, EntityManagerInterface $entityManagerInterface)
    {
        $repo = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);

        foreach ($repo as $ligne) {

            if ($ligne->getProduit()->getId() === $produit->getId()) {
                $ligne->setQuantite($ligne->getQuantite() - 1);
                $entityManagerInterface->persist($ligne);
                $entityManagerInterface->flush();
            }
            if ($ligne->getQuantite() == 0) {
                $entityManagerInterface->remove($ligne);
                $entityManagerInterface->flush();
            }
        };

        return $this->redirectToRoute("panier");
    }



    /**
     * @Route("/panier/commande", name="commande")
     */
    public function commande(PanierRepository $panierRepository, ProduitRepository $produitRepository, EntityManagerInterface $entityManagerInterface)
    {

        $listeproduits = $produitRepository->findAll();
        $repo = $panierRepository->findBy([
            'utilisateur' => $this->getUser()->getId()
        ]);

        $commande = new Commande();


        foreach ($repo as $value) {
            $commande = new Commande();
            $commande->setProduitId($value->getProduit()->getId());
            $commande->setProduitNom($value->getProduit()->getNom());
            $commande->setProduitPrix($value->getProduit()->getPrix());
            $commande->setProduitQuantite($value->getQuantite());
            $value->getProduit()->setStock($value->getProduit()->getStock() - $value->getQuantite() );
            $commande->setUtilisateur($this->getUser());
            $commande->setCreatedAt(new \DateTime());

            $entityManagerInterface->persist($value->getProduit());
            $entityManagerInterface->persist($commande);
            $entityManagerInterface->remove($value);
        };


        $entityManagerInterface->flush();
        $this->addFlash('commandeOk', 'Félicitaions ! Votre commande est validée.');
        return $this->redirectToRoute("panier");
    }

    
}
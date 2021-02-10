<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\CreationProduitForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationProduitController extends AbstractController
{
    /**
     * @Route("/creationproduit", name="creation_produit")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $produit = new Produit();
        $form = $this->createForm(CreationProduitForm::class, $produit);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            //on enregistre le produit en bdd

            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute("produits_admin");
           /*  return new Response ('Produit ajouté !'); */
        }

        return $this->render('creation_produit/index.html.twig', [
            'creationproduitform' => $form->createView(),
        ]);
    }


    /**
     * @Route("/modif_produit/{id}", name="modif_produit")
     */
    public function modifProduit(Produit $produit , Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(CreationProduitForm::class, $produit);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            //on enregistre le produit en bdd
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute("produits_admin");
        }

        return $this->render('creation_produit/index.html.twig', [
            'creationproduitform' => $form->createView(),
        ]);
    }
}

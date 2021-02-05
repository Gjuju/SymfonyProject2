<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\CreationProduitForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationProduitController extends AbstractController
{
    #[Route('/creationproduit', name: 'creation_produit')]
    public function index(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm(CreationProduitForm::class);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            //on enregistre le produit en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($produit);
            $em->flush();

            return new Response ('Produit ajouté !');
        }

        return $this->render('creation_produit/index.html.twig', [
            'creationproduitform' => $form->createView(),
        ]);
    }
}

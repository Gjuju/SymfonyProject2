<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/commandes_admin", name="commandes_admin")
     */
    public function commandesAdmin(): Response
    {
        return $this->render('admin/commandes_admin.html.twig', [
            
        ]);
    }

    /**
     * @Route("/produits_admin", name="produits_admin")
     */
    public function produitAdmin(): Response
    {
        return $this->render('admin/produits_admin.html.twig', [
            
        ]);
    }


    /**
     * @Route("/commandes_user", name="commandes_user")
     */
    public function commandesUser (): Response
    {
        return $this->render('admin/commandes_user.html.twig', [

        ]);
    }

    /**
     * @Route("/compte_user", name="compte_user")
     */
    public function compteUser (): Response
    {
        return $this->render('admin/compte_user.html.twig', [

        ]);
    }
}

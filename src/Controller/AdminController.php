<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminController extends AbstractController
{

    /**
     * @Route("/compte", name="compte")
     */
    public function compte (): Response
    {
        return $this->render('admin/compte.html.twig', [

        ]);
    }

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
     * @Route("/compte_user/{id}", name="compte_user")
     */
    public function compteUser (Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $utilisateur);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('password')->getData()
                )
            );
            //$utilisateur->setRoles(["ROLE_USER"]);
            $utilisateur->setUsername($utilisateur->getFirstname());
    
        $entityManager->persist($utilisateur);
        $entityManager->flush();
        return $this->redirectToRoute('compte_user', [ 'id' => $utilisateur->getId()]);
        }

        return $this->render('admin/compte_user.html.twig', [
            'utilsateur' => $utilisateur,
            'userForm' => $form->createView()
        
        ]);
    
    }   
    
}

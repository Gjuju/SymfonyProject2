<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Form\PassInfosType;
use App\Form\RegistrationFormType;
use App\Form\UserInfosType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
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
    public function compte(): Response
    {
        return $this->render('admin/compte.html.twig', []);
    }

    /**
     * @Route("/commandes_admin", name="commandes_admin")
     */
    public function commandesAdmin(CommandeRepository $commandeRepository, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commandeRepository->getAdminCommandePaginator($offset);

        //dd($paginator);
        $array = [];
        foreach ($paginator as $value) {
            array_push($array, $value);
        }

        //dd($paginator, $array);
        return $this->render('admin/commandes_admin.html.twig', [
            'commandes' => $paginator
        ]);
    }


    /**
     * @Route("/commandes_user", name="commandes_user")
     */
    public function commandesUser(CommandeRepository $commandeRepository, Request $request): Response
    {
        $id = $this->getUser()->getId();

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commandeRepository->getUserCommandePaginator($offset, $id);

        $array = [];
        foreach ($paginator as $value) {
            array_push($array, $value);
        }

        //dd($paginator, $array);

        return $this->render('admin/commandes_user.html.twig', [
            'commandes' => $paginator
        ]);
    }


    /**
     * @Route("/commande_detail/{id}/{idCommande}/{createdAt}", name="commande_detail")
     */
    public function commandeDetail(int $id, int $idCommande, string $createdAt,  UtilisateurRepository $utilisateurRepository, CommandeRepository $commandeRepository): Response
    {

        $user = $utilisateurRepository->findby([
            'id' => $id
        ]);

        $paginator = $commandeRepository->getDetailCommandePaginator($id, $createdAt);

        //dd($paginator);
        $total = 0;
        foreach ($paginator as $value) {
            $total += $value->getProduitPrix() * $value->getProduitQuantite();
            //$user = $value->getUtilisateur();
        }
        
        //dd($user[0]);
        return $this->render('admin/commandeDetail.html.twig', [
            'utilisateur' => $user[0],
            'total' => $total,
            'commande' => $paginator,
            'idcommande' => $idCommande
        ]);
    }

    /**
     * @Route("/produits_admin", name="produits_admin")
     */
    public function produitAdmin(ProduitRepository $produitRepository): Response
    {

        $produits = $produitRepository->findAll();

        return $this->render('admin/produits_admin.html.twig', [
            'produits' => $produits
        ]);
    }


    /**
     * @Route("/compte_user/{id}", name="compte_user")
     */
    public function compteUser(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$user = new Utilisateur();
        $formUser = $this->createForm(UserInfosType::class, $utilisateur);
        $formPass = $this->createForm(PassInfosType::class, $utilisateur);


        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->addFlash('success', 'Votre Compte a bien été modifié');


            //$utilisateur->setRoles(["ROLE_USER"]);
            $utilisateur->setUsername($utilisateur->getFirstname());

            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('compte_user', ['id' => $utilisateur->getId()]);
        }



        $formPass->handleRequest($request);
        if ($formPass->isSubmitted() && $formPass->isValid()) {
            $this->addFlash('success', 'Votre Compte a bien été modifié');

            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $formPass->get('password')->getData()
                )
            );
            //$utilisateur->setRoles(["ROLE_USER"]);
            $utilisateur->setUsername($utilisateur->getFirstname());

            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('compte_user', ['id' => $utilisateur->getId()]);
        }

        return $this->render('admin/compte_user.html.twig', [
            'utilsateur' => $utilisateur,
            'formPass' => $formPass->createView(),
            'formUser' => $formUser->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/logadmin", name="logadmin")
     */
    public function logAdmin(): Response
    {
        return $this->render('logadmin/logAdmin.html.twig', [
            
        ]);
    }

    /**
     * @Route("/user", name="loguser")
     */
    public function logUser (): Response
    {
        return $this->render('user/logUser.html.twig', [

        ]);
    }
}

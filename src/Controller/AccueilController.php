<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/accueil")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            $this->getUser()->setNombreEssai(0);
            $entityManager->flush();
        }

        if ($this->getUser()->getPremierConnexion()) {
            return $this->redirectToRoute('user_change_password', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class LoginController extends AbstractController
{

     /**
     * @Route("/", name="index")
     */
    public function login(EntityManagerInterface $entityManager): Response
    {
        
            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
       
    }

    /**
     * @Route("/login", name="login", methods={"GET","POST"})
     */
    public function index(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
         
        $user=$entityManager->getRepository(User::class)->findOneBy(['username' =>  $lastUsername]);

        if ($user) {
           $user->setNombreEssai($user->getNombreEssai()+1);

           if ($user->getNombreEssai()>=2) {
              $user->setEnabled(0);
           }
        }

      

         $entityManager->flush();

        

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
             'error'         => $error,
        ]);
    }

     /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('ok');
    }
}

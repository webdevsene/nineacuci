<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class LoginController extends AbstractController
{

     /**
     * @Route("/", name="index")
     *  @Security(" is_granted('ROLE_USER')")
     */
    public function login(EntityManagerInterface $entityManager): Response
    {

        if ($this->isGranted('ROLE_NINEA') && $this->isGranted('ROLE_CUCI')) { 
        
              return $this->render('login/accueil.html.twig', []);
        }else
          if($this->isGranted('ROLE_NINEA') ){
            return $this->redirectToRoute('ninea_accueil', [], Response::HTTP_SEE_OTHER);
          }else
         {
          return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
          }
       
    }

    /**
     * @Route("/login", name="login", methods={"GET","POST"})
     */
    public function index(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
         
        $user=$entityManager->getRepository(User::class)->findOneBy(['username' =>  $lastUsername]);

       

        

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
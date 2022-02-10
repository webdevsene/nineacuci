<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



/**
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = [];
        
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            
            $users = $userRepository->findAll();
         }else
        if ($this->isGranted('ROLE_BSE_ADMIN')) {
            // Execute some php code here

            $users  = $userRepository->findUsersByRoles('ROLE_BSE_ADMIN', 'ROLE_BSE_AGENT_SAISIE') ;
            //die();
            
         }else
         {
          
            // $users  = $userRepository->findUsersByRoles('ROLE_BREA_ADMIN', 'ROLE_BREA_AGENT_SAISIE') ;
            $users  = $userRepository->findUsersByRoles('ROLE_BREA_ADMIN', 'ROLE_BREA_AGENT_SAISIE') ;
         }

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        
        if ($this->isGranted('ROLE_SUPER_ADMIN')) { 
            $inputRoles = [ 
                'Super admin' => "ROLE_SUPER_ADMIN",
                'Admin BREA' => "ROLE_BREA_ADMIN",
                'Agent saisie BREA' => "ROLE_BREA_AGENT_SAISIE",
                'Admin BSE' => "ROLE_BSE_ADMIN",
                'Agent saisie BSE' => "ROLE_BSE_AGENT_SAISIE",
            ];
         }else
        if ($this->isGranted('ROLE_BSE_ADMIN')) {
            // Execute some php code here

            $inputRoles =[ 'Admin BSE' => "ROLE_BSE_ADMIN", 'Agent saisie BSE' => "ROLE_BSE_AGENT_SAISIE"];
            
           
         }else
         {
          
            $inputRoles =[ 'Admin BREA' => "ROLE_BREA_ADMIN",
            'Agent saisie BREA' => "ROLE_BREA_AGENT_SAISIE"];

         }



        $form = $this->createForm(UserType::class, $user, [
            "inputRoles"=>$inputRoles,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $plaintextPassword = $form['plainPassword']->getData();

            $user->setPremierConnexion(true);
            $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

         

            return $this->redirectToRoute('user_show', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/activer/{id}", name="user_activer", methods={"GET"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function activer(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setEnabled(true);
        $user->setNombreEssai(0);
        $entityManager->flush();
        $request->getSession()->getFlashBag()->add('message',"Compte a été activé avec succés");
        return $this->redirectToRoute('user_show', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
    }


     /**
     * @Route("/desactiver/{id}", name="user_desactiver", methods={"GET"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function desactiver(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setEnabled(0);
        $user->setNombreEssai(0);
        $entityManager->flush();
        $request->getSession()->getFlashBag()->add('message',"Compte a été désactivé avec succés");
        return $this->redirectToRoute('user_show', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/reinisialiser/{id}", name="user_reinisialiser", methods={"GET"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function reinisialiser(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {

        $plaintextPassword = "azerty";

             
        $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
        $user->setPassword($hashedPassword);
        $entityManager->flush();
        $request->getSession()->getFlashBag()->add('message',"Le mot de passe a été réinitialisé avec succés");
        return $this->redirectToRoute('user_show', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) { 
            $inputRoles = [ 
                'Super admin' => "ROLE_SUPER_ADMIN",
                'Admin BREA' => "ROLE_BREA_ADMIN",
                'Agent saisie BREA' => "ROLE_BREA_AGENT_SAISIE",
                'Admin BSE' => "ROLE_BSE_ADMIN",
                'Agent saisie BSE' => "ROLE_BSE_AGENT_SAISIE",
            ];
         }else
        if ($this->isGranted('ROLE_BSE_ADMIN')) {
            // Execute some php code here

            $inputRoles =[ 'Admin BSE' => "ROLE_BSE_ADMIN", 'Agent saisie BSE' => "ROLE_BSE_AGENT_SAISIE"];
            
           
         }else
         {
          
            $inputRoles =[ 'Admin BREA' => "ROLE_BREA_ADMIN",
            'Agent saisie BREA' => "ROLE_BREA_AGENT_SAISIE"];

         }


        $form = $this->createForm(UserEditType::class, $user,[
            "inputRoles"=>$inputRoles,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

     /**
     * @Route("/changerMotdePasse/{id}", name="user_change_password", methods={"GET", "POST"})
     */
    public function changerMotdePasse(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
       

        if ($request->get('password')) {
            
            $hashedPassword = $passwordHasher->hashPassword($user,$request->get('password'));
            $user->setPassword($hashedPassword);
            $user->setPremierConnexion(false);
            $entityManager->flush();

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/user_changePassword.html.twig', [
            'user' => $user,
            
        ]);
    }


     /**
     * @Route("/nomUtilisateur/{username}", name="user_nomUtilisateur", methods={"GET"})
     */
    public function nomUtilisateur($username="")
    {


         $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['username' =>  $username]);
       

        if ($user) {
            
           return new JsonResponse(1);
        }else{
           
           return new JsonResponse(0);
        }

       
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     * @Security("is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN')")
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}

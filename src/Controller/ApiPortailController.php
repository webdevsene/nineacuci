<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserDematRepository;
use App\Entity\UserDemat;
use App\Entity\NiNineaproposition;
use App\Entity\NiFormeunite;
use App\Entity\NiFormejuridique;
use App\Entity\NiStatut;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\DiversUtils;

use App\Entity\CompteurDemandeNINEA;
use App\Repository\NiFormeuniteRepository;
use App\Repository\NiFormejuridiqueRepository;
use App\Repository\NiStatutRepository;


class ApiPortailController extends AbstractController
{
    /**
     * @Route("/api/userdemat", name="api_userdemat_index", methods={"GET"})
     */
    public function index(UserDematRepository $userdematrepository): Response
    {
        $userdemats=$userdematrepository->findAll();

        return $this->json($userdemats, 200);

      //  dd($userdematsNormalises);
    }

    /**
     * @Route("/api/listeformeunitedemat", name="listeformeunitedemat", methods={"GET"})
     */
    public function listeformeunitedemat(NiFormeuniteRepository $formeunitrepository): Response
    {
        $formunites=$formeunitrepository->findAll();
       // dd($formunites);

        return $this->json($formunites, 200,[], ['groups'=>'formeunit:read']);

      //  dd($formunites);
    }

     /**
     * @Route("/api/listeformejuridiquedemat", name="listeformejuridiquedemat", methods={"GET"})
     */
    public function listeformejuridiquedemat(NiFormejuridiqueRepository $formejuridiquerepository): Response
    {
        $formejuridiques=$formejuridiquerepository->findAll();
       // dd($formejuridiques);

        return $this->json($formejuridiques, 200,[], ['groups'=>'formejuridique:read']);

    }

    /**
     * @Route("/api/listestatutdemat", name="listestatutdemat", methods={"GET"})
     */
    public function listestatutdemat(NiStatutRepository $statutrepository): Response
    {
        $statuts=$statutrepository->findAll();
       // dd($statuts);

        return $this->json($statuts, 200,[], ['groups'=>'statut:read']);

    }

    /**
     * @Route("/api/userdemat", name="api_userdemat_seConnecter", methods={"POST"})
     */
    public function seConnecter(Request $request,UserDematRepository $userdematrepository, SerializerInterface $serializer, EntityManagerInterface $emi): Response
    {
      $jsonrecu = $request->getContent();
      $userdemats=$serializer->deserialize($jsonrecu, UserDemat::class, "json");
      

      $userdemats=$userdematrepository->findBy(array("Email"=>$userdemats->getEmail(),"Password"=>$userdemats->getPassword()));
      if(count($userdemats)>0){
        return $this->json([
          'codeRetour'=>'OK',
          'messageRetour'=> 'Informations de connections corrects'
        ], 201,[]);
      }
      else{
        return $this->json([
          'codeRetour'=>'NONOK',
          'messageRetour'=> 'Informations de connections non corrects'
        ], 201,[]);
      }
  
     // dd($userdemats);

    //  return $this->json($userdemats, 201,[]);

    }

    /**
     * @Route("/api/userdematinscrire", name="api_userdemat_inscrire", methods={"POST"})
     */
    public function inscrire(Request $request, SerializerInterface $serializer, EntityManagerInterface $emi): Response
    {
      $jsonrecu = $request->getContent();
            
      $userdemats=$serializer->deserialize($jsonrecu, UserDemat::class, "json");
      $emi->persist($userdemats);
      $emi->flush();

      //dd($userdemats);
      if($userdemats->getId()>0){
        return $this->json([
          'codeRetour'=>'OK',
          'messageRetour'=> 'Inscription Reussie'
        ], 201,[]);
      }
      else{
        return $this->json([
          'codeRetour'=>'NONOK',
          'messageRetour'=> 'Inscription non Reussie'
        ], 201,[]);
      }

      return $this->json($userdemats, 201,[]);
      

    }

/**
     * @Route("/api/newDemandeDemat", name="api_newDemande_Demat", methods={"POST"})
     */
    public function newDemandeDemat(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager,  DiversUtils $diversUtils): Response
    {
      $demandeDematRecu = $request->getContent();
      //dd($demandeDematRecu);
      $data = json_decode($demandeDematRecu, true);

      $ninDatreg=$data["ninDatreg"];
      $ninEnseigne=$data["ninEnseigne"];
     // $ninFormeUnite=$data["ninFormeUnite"];
      $ninFormejuridique=$data["ninFormejuridique"];
      $ninRegcom=$data["ninRegcom"];
      $ninStatut=$data["ninStatut"];


      //dd($data);
      $niNineaproposition = new NiNineaproposition();
        $niNineaproposition->setNinmajdate(new \DateTime());


     $niNineaproposition->setNinmajdate(new \DateTime());
     $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
     $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();

     $CompteurDemandeNINEA = new CompteurDemandeNINEA();
   //  dd($niNineaproposition);

     $niNineaproposition->setNinFormejuridique($entityManager->getRepository(NiFormejuridique::class)->find($ninFormejuridique));
     $niNineaproposition->setCreatedBy($this->getUser());
     $niNineaproposition->setUpdatedBy($this->getUser());

      //generer le code de numéro de demande
      $numDemande=$diversUtils->numDemandeSuivant($entityManager);
      $niNineaproposition->setNinnumerodemande($numDemande);
      $niNineaproposition->setStatut("b");

      $niNineaproposition->setNinEnseigne($ninEnseigne);
      $niNineaproposition->setNinDatreg(new \DateTime($ninDatreg));
      $niNineaproposition->setNinRegcom($ninRegcom);
      $niNineaproposition->setNinStatut($entityManager->getRepository(NiStatut::class)->find($ninStatut));
     //dd($niNineaproposition);

      $entityManager->persist($niNineaproposition);
      $entityManager->persist($CompteurDemandeNINEA);
      $entityManager->flush();

   //  dd($niNineaproposition);
;

     if($niNineaproposition->getId() && $niNineaproposition->getId()>0){
      return $this->json([
        'codeRetour'=>'OK',
        'messageRetour'=> 'Reussie'.$niNineaproposition->getNinnumerodemande()
      ], 201,[]);
    }
    else{
      return $this->json([
        'codeRetour'=>'NONOK',
        'messageRetour'=> 'non Reussie'
      ], 201,[]);
    }

      return $this->json($niNineaproposition, 201,[]);
      

    }



}

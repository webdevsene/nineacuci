<?php

namespace App\Controller;

use App\Entity\CAV;
use App\Entity\QVH;
use App\Entity\CACR;
use App\Entity\Citi;
use App\Entity\Pays;
use App\Entity\NAEMA;


use App\Entity\NAEMAS;
use App\Entity\NiSexe;
use App\Entity\Region;
use App\Entity\SYSCOA;
use App\Entity\NINinea;
use App\Entity\NiActivite;
use App\Entity\NiCivilite;
use App\Entity\NiPersonne;
use App\Entity\NiTypevoie;
use App\Entity\Departement;
use App\Entity\CategoryCiti;
use App\Entity\NiFormeunite;
use App\Entity\NiPerception;
use App\Entity\CategoryNaema;
use App\Entity\CompteurNINEA;
use App\Entity\NiCoordonnees;
use App\Entity\NiNationalite;
use App\Entity\NiTypepersone;
use App\Services\DiversUtils;
use App\Entity\CategoryNaemas;

use App\Entity\CategorySyscoa;
use Doctrine\ORM\EntityManager;
use App\Entity\NiFormejuridique;
use App\Entity\NiNineaproposition;
use App\Entity\CompteurDemandeNINEA;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiDirigeant;
use App\Entity\NinJourFerier;
use App\Entity\Ninproduits;
use App\Entity\NinTypedocuments;
use App\Entity\NiStatut;
use App\Entity\Qualite;
use App\Entity\RefProduits;
use App\Form\NiActivite2Type;
use App\Form\NiActiviteEconomiqueType;
use App\Form\NiActiviteType;
use App\Form\NiCoordonneesType;
use App\Form\NiDirigeantType;
use App\Form\NiNineapropositionAncienNINEAType;
use App\Form\NiNineapropositionType;
use App\Form\NiNineaPropositionShowType;
use App\Form\NINineaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NiNineapropositionRepository;
use App\Repository\NINineaRepository;
use App\Repository\NiPersonneRepository;
use Container3BrWV8L\getSYSCOAService;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



/**
 * @Route("/nineaproposition")
 * @Security("is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class NiNineapropositionController extends AbstractController
{

  
     /**
     * @Route("/listeBrouillons", name="listeBrouillons", methods={"GET"})
     * 
     */
    public function listeBrouillons(EntityManagerInterface $entityManager,AuthorizationCheckerInterface $autorization): Response
    {
      $nineapropsition = "";
            
      if ($autorization->isGranted("ROLE_VALIDER_DEMANDE_NINEA" ) or $autorization->isGranted("ROLE_ADMIN" )) {
     
        $nineapropsition =  $entityManager->getRepository(NiNineaproposition::class)->findBrouillonsByCentre($this->getUser(), "b");

     }
      else if ($autorization->isGranted("ROLE_DEMANDE_NINEA"))
      {
        $nineapropsition = $entityManager->getRepository(NiNineaproposition::class)->findBrouillonsByCentre($this->getUser(), "b");

        // $nineapropsition = $entityManager->getRepository(NiNineaproposition::class)->findBy(array("ninAdministration"=>$this->getUser()->getNiAdministration(),"statut"=>'b'),array('id'=>'desc'));
      }

        return $this->render('ni_nineaproposition/indexB.html.twig', [
            'ni_nineapropositions' =>$nineapropsition ,
        ]);
    }

    
    /**
     * @Route("/", name="ni_nineaproposition_index", methods={"GET"})
     * 
     */
    public function index(NiNineapropositionRepository $niNineapropositionRepository,AuthorizationCheckerInterface $autorization): Response
    {
      $nineapropsition = "";
            
      if ($autorization->isGranted("ROLE_VALIDER_DEMANDE_NINEA" ) or $autorization->isGranted("ROLE_ADMIN" )) {

        $nineapropsition = $niNineapropositionRepository->findDemande();
     }
      else  if ($autorization->isGranted("ROLE_DEMANDE_NINEA"))
      {
        $nineapropsition = $niNineapropositionRepository->findByCentre2($this->getUser(),'b');
      }

        return $this->render('ni_nineaproposition/index.html.twig', [
            'ni_nineapropositions' =>$nineapropsition ,
        ]);
        
    }



     /**
     * @Route("/a_valider", name="a_valider", methods={"GET"})
     * 
     */
    public function a_valider(NiNineapropositionRepository $niNineapropositionRepository,AuthorizationCheckerInterface $autorization): Response
    {
      $nineapropsition = "";
            
      if ($autorization->isGranted("ROLE_VALIDER_DEMANDE_NINEA" ) or $autorization->isGranted("ROLE_ADMIN" )) {

        $nineapropsition = $niNineapropositionRepository->findAValider();
     }
      else  if ($autorization->isGranted("ROLE_DEMANDE_NINEA"))
      {
        $nineapropsition = $niNineapropositionRepository->findByCentre2($this->getUser(),'b');
      }

        return $this->render('ni_nineaproposition/index.html.twig', [
            'ni_nineapropositions' =>$nineapropsition ,
        ]);
        
    }


         /**
     * @Route("/supprimerDirigeants/{id}", name="supprimerDirigeants", methods={"GET", "POST"})
     */
    public function supprimerDirigeants(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

      $session= new Session();
      $session->set('actived',5);

      $dirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
      $niNineaproposition = $dirigeant->getNinNineaProposition();
      
      $niNineaproposition->removeDirigeant($dirigeant);
      $entityManager->remove($dirigeant);
      $entityManager->flush();

       return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
    }


       /**
     * @Route("/modifierDirigeants/{id}", name="modifierDirigeants", methods={"GET", "POST"})
     */
    public function modifierDirigeants(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $session= new Session();
        $session->set('actived',5);

        $dirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
        $niNineaproposition = $dirigeant->getNinNineaProposition();

      if($request->get("cni"))
      {
        $session= new Session();
        $session->set('actived',5);

        $nationalite = $entityManager->getRepository(NiStatut::class)->find($request->get("nationalite"));
        $cni = $request->get('cni');
        $datecni = $request->get('datecni');
        $nationalite = $request->get("nationalite");
        if( $nationalite=="SN"){
          $cni = $request->get("cni");
          $datecni = $request->get("dateCni");
          $dirigeant->setNinCni($cni);
          $dirigeant->setNinDateCni(new \DateTime($datecni));
      }
      else {
          $passport = $request->get("passport");
          $datepassport = $request->get("datepassport");
          $dirigeant->setNinCni($passport);
          $dirigeant->setNinDateCni(new \DateTime($datepassport));
      }
                
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        //$adresse = $request->get("adresse");
        $civilite = $request->get("civilite");
        $datenais = $request->get("datenais");
        //$lieunais = $request->get("lieunais");
        $nsexe = $request->get("sexe");
        $email = $request->get("email");
        $qualification = $request->get("qualification");
        $telephone = $request->get("telephone");
        //$qvh = $request->get("qvh");
        $adresse = $request->get("adresse");

      $dirigeant->setNinNom($nom);
      $dirigeant->setNinPrenom($prenom);
      //$personne->setAdresse($adresse);
      $dirigeant->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
      $dirigeant->setNinDatenais(new \DateTime($datenais));
      //$dirigeant->setNinLieunais($lieunais);
      $dirigeant->setNinTelephone1($telephone);
      $dirigeant->setNinEmail($email);
      $dirigeant->setNinAddresse($adresse);
      $dirigeant->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualification));

      $dirigeant->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
      $dirigeant->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));

    //  $dirigeant->setModifiedBy($this->getUser());
      $dirigeant->setDateDeCloture(new \DateTime());
           
    // $entityManager->persist($dirigeantNouveau);
     $entityManager->flush();
    
     return $this->redirectToRoute('ni_nineaproposition_show', ["id"=> $niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
    
      }
      else if($request->get("enlever"))
      {
        $dirigeant->getModifiedBy($this->getUser());
        $dirigeant->setDateDeCloture(new \DateTime());

        $entityManager->flush();

        return $this->redirectToRoute('ni_nineaproposition_show', ["id"=> $niNineaproposition->getId()], Response::HTTP_SEE_OTHER);

   }

       // var_dump($dirigeant);
       return $this->redirectToRoute('ni_nineaproposition_show', ["id"=> $niNineaproposition->getId(),"dirigeant"=> $dirigeant->getId()], Response::HTTP_SEE_OTHER);
    }

    
    /**
     * @Route("/ajouterDirigeants/{id}", name="ajouterDirigeants", methods={"GET", "POST"})
     */
    public function ajouterDirigeants(NiNineaproposition $niNineaproposition, Request $request, EntityManagerInterface $entityManager): Response
    {

        $max = new \DateTime("-10 years");
    
        $session= new Session();
        $session->set('actived',5);

       // var_dump($session);

        if($request->get("cni") || $request->get("passport"))
        {
          $dirigeant =  new NiDirigeant();


          $nationalite = $entityManager->getRepository(NiStatut::class)->find($request->get("nationalite"));
          $cni = $request->get('cni');
          $datecni = $request->get('datecni');
          $nationalite = $request->get("nationalite");
          if( $nationalite=="SN"){
            $cni = $request->get("cni");
            $datecni = $request->get("dateCni");
            $dirigeant->setNinCni($cni);
            $dirigeant->setNinDateCni(new \DateTime($datecni));
        }
        else {
            $passport = $request->get("passport");
            $datepassport = $request->get("datepassport");
            $dirigeant->setNinCni($passport);
            $dirigeant->setNinDateCni(new \DateTime($datepassport));
        }
                  
          $nom = $request->get("nom");
          $prenom = $request->get("prenom");
          //$adresse = $request->get("adresse");
          $civilite = $request->get("civilite");
          $datenais = $request->get("datenais");
          $lieunais = $request->get("lieunais");
          $nsexe = $request->get("sexe");
          $email = $request->get("email");
          $qualification = $request->get("qualification");
          $telephone = $request->get("telephone");
          $qvh = $request->get("qvh");
          $adresse = $request->get("adresse");

          $dirigeant->setNinNom($nom);
          $dirigeant->setNinPrenom($prenom);
          //$personne->setAdresse($adresse);
          $dirigeant->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
          $dirigeant->setNinDatenais(new \DateTime($datenais));
          $dirigeant->setNinTelephone1($telephone);
          $dirigeant->setNinEmail($email);
          $dirigeant->setNinAddresse($adresse);
          $dirigeant->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualification));

          $dirigeant->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
          $dirigeant->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
         
          $dirigeant->setNinNineaProposition($niNineaproposition);
          
          $entityManager->persist($dirigeant);
          $entityManager->flush();
         
          return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
        
        }

        $session->set('PageAjoutDirigeant',1);

        return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
    }


     /**
     * @Route("/ajouterActivite_economique/{id}", name="ajouterActivite_economique", methods={"GET", "POST"})
     */
    public function ajouterActivite_economique(NiNineaproposition $niNineaproposition, Request $request, EntityManagerInterface $entityManager): Response
    {

          $activite_economique = new NiActiviteEconomique();

          $form = $this->createForm(NiActiviteEconomiqueType::class, $activite_economique);
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
           if($request->get("ni_activite"))
            $activite_economique->setNinAffaire( str_replace(" ","" , $request->get("ni_activite")));
           if(count($niNineaproposition->getNiActiviteEconomiques())==0){
            if ($niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId() == 11 or 
                $niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId() == 12)
                {
                  $session= new Session();
                  $session->set('actived',"4");
                }
            else 
            {
              $session= new Session();
              $session->set('actived',5);
            }
            
            $activite_economique->setCreateBy($this->getUser());

            $activite_economique->setNiNineaproposition($niNineaproposition);
           
            $entityManager->persist($activite_economique);
            $entityManager->flush();
          }
  
            return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
            
          
          }
        
        return $this->render('ni_nineaproposition/activite_economique.html.twig', [
           'niNineaproposition' => $niNineaproposition,
           'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/ajouterPersonne/{id}", name="ajouterPersonnes", methods={"GET", "POST"})
     */
    public function ajouterPersonne(NiNineaproposition $niNineaproposition, Request $request, EntityManagerInterface $entityManager): Response
    {

        $sexes = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();

        $typevoie = null;

        if ($request->get("nom") || $request->get("raison")) 
        {
          
            $session= new Session();
            $session->set('actived',2);

            $personne = new NiPersonne();
            $nsexe = $request->get("sexe");

            if ($request->get("qvh"))
            {
              $qvh_personne =  $request->get("qvh");
              $personne->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh_personne));

            }    
           
            if ($niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId() == 11 
                or $niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId() == 12 )
            {

                //récupération personne physique
                $nom = $request->get("nom");
                $prenom = $request->get("prenom");
                $adresse = $request->get("adresse");
                $civilite = $request->get("civilite");
                $datenais = $request->get("datenais");
                $lieunais = $request->get("lieunais");
                $nationalite = $request->get("nationalite");
                $telephone = $request->get('telephone');
                $nsexe = $request->get("sexe");
                $email = $request->get('email');
                if ($request->get("typevoie"))
                {
                  $typevoie = $request->get("typevoie");
                }
                $voie = $request->get('voie');
                $numvoie = $request->get('numvoie');

                $personne->setNinNom($nom);
                $personne->setNinPrenom($prenom);
                $personne->setNinEmailPersonnel($email);
                $personne->setNinTelephone($telephone);
                $personne->setAdresse($adresse);
                $personne->setNinVoie($voie);
                $personne->setNumVoie($numvoie);
                $personne->setCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
                $personne->setNinDateNaissance(new \DateTime($datenais));
                $personne->setNinLieuNaissance($lieunais);
                $personne->setNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
                $personne->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
                if ($typevoie)
                {
                  $personne->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
                }
                
                // Recherche de tous les articles en fonction de multiples conditions
                // $articles = $repository->findBy(
                //   ['author' => 'Léa'],
                //   ['title' => 'ASC'], // le deuxième paramètre permet de définir l'ordre
                //   10, // le troisième la limite
                //   2 // et à partir duquel on récupère ("OFFSET" au sens MySQL)
                // );
                  if( $nationalite=="SN"){
                      $cni = $request->get("cni");
                      //parcourir la base de données

                      $datecni = $request->get("datecni");

                      $controleCni = $this->getDoctrine()->getRepository(NINinea::class)->findPersonneByNinea($cni);
                      if (count($controleCni) > 0)
                        {
                          $request->getSession()->getFlashBag()->add('messageCNI',"Ce CNI a déjà un NINEA.");
                  
                          return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
                        }
                                    
                      $personne->setNinCNI($cni);
                      if($datecni)
                          $personne->setNinDateCNI(new \DateTime($datecni));
                  }
                  else {
                      $passport = $request->get("passport");
                      $datepassport = $request->get("datepassport");
                      $personne->setNinCNI($passport);
                      if($datepassport)
                          $personne->setNinDateCNI(new \DateTime($datepassport));
                  }
            
                    $personne->setNinRaison("");
                    $personne->setNinSigle("");

                    if($niNineaproposition->getNinStatut()->getId() == 1)
                    {
                      $personne->addNiNineaproposition($niNineaproposition);
                      $personne->setCreatedBy($this->getUser());
                      $entityManager->persist($personne);
                      $entityManager->flush();
                    }else{
                      $nin_nineamere = $niNineaproposition->getNinNineamere();
                      $niNinea_mere =  $entityManager->getRepository(NINinea::class)->findOneBy(['ninNinea' => $nin_nineamere]);
                      $niNinea_mere->getNiPersonne()->addNiNineaproposition($niNineaproposition);
                      $personne->setCreatedBy($this->getUser());
                      $entityManager->flush();
                    }
                    return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);

              } else
              {
                  //recupération personne morale
                $raison = $request->get("raison");
                $sigle = $request->get("sigle");
                $personne->setNinRaison($raison);
                $personne->setNinSigle($sigle);
                $personne->addNiNineaproposition($niNineaproposition);
                $personne->setCreatedBy($this->getUser());
                $entityManager->persist($personne);
                $entityManager->flush();
              }
            
          
         // $request->getSession()->getFlashBag()->add('message',"Personne a été ajoutée avec succés.");
            
            return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
          
        } 
        

        return $this->render('ni_nineaproposition/personneform.html.twig', [
          'id'=>$niNineaproposition->getId(),
           'niNineaproposition' => $niNineaproposition,
           'regions' => $regions,
           'nationalites' => $nationalites,
           'sexes' => $sexes,
           'civilites' => $civilites,
            'departements' => $departements,
            'cavs' => $cavs,
            'cacrs' => $cacrs,

        ]);
    }


      /**
     * @Route("/ajouterCoordonnees/{id}", name="ajouterCoordonnees", methods={"GET", "POST"})
     */
    public function ajouterCoordonnees(NiNineaproposition $niNineaproposition, Request $request, EntityManagerInterface $entityManager): Response
    {       

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $typevoie="";
        if ($request->get('ajouter')) 
        {
          $session= new Session();
          $session->set('actived',3);

          $coordonnee = new NiCoordonnees();
          if ($request->get("typevoie"))
          {
            $typevoie = $request->get("typevoie");
          }
          $qvh =  $request->get("qvh");
          $numvoie = $request->get("numvoie");
          $voie = $request->get("voie");
          $adresse1 = $request->get("adresse1");
          $telephone1 = $request->get("telephone1");
          $telephone2 = $request->get("telephone2");
          $email = $request->get("email");
          $boitepostale =  $request->get("bp");   
          $url =  $request->get("url");   

          if ($typevoie)
          {
            $coordonnee->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
          }
          $coordonnee->setNinVoie($voie);
          $coordonnee->setNinnumVoie($numvoie);
          $coordonnee->setNinadresse1($adresse1);
           $coordonnee->setNintelephon2($telephone2);
           $coordonnee->setNinTelephon1($telephone1);
           $coordonnee->setNinEmail($email);
           $coordonnee->setQvh($entityManager->getRepository(QVH::class)->find($qvh));
           $coordonnee->setNinBP($boitepostale);
           $coordonnee->setNinUrl($url);

           $coordonnee->setCreateBy($this->getUser());
           $coordonnee->setUpdateBy($this->getUser());

          $coordonnee->setNiNineaproposition($niNineaproposition);

          $entityManager->persist($coordonnee);
          $entityManager->flush();

            return $this->redirectToRoute('ni_nineaproposition_show', [
              'id'=>$niNineaproposition->getId(), 
            
            ], Response::HTTP_SEE_OTHER);
          
        }

        return $this->render('ni_nineaproposition/coordonnees.html.twig', [
           'regions' => $regions,
           'nationalites' => $nationalites,
           'sexe' => $sexe,
           'civilites' => $civilites,
           'typevoies' => $typevoies,
          
        ]);
    }



    /**
     * @Route("/ajouterActivites/{id}", name="ajouterActivites", methods={"GET", "POST"})
     */
    public function ajouterActivites(NiNineaproposition $niNineaproposition, Request $request, EntityManagerInterface $entityManager): Response
    {

      $session= new Session();
      $session->set('actived',4);

        $activite = new NiActivite();
        $form3 = $this->createForm(NiActiviteTypeType::class, $activite);
        $form3->handleRequest($request);
          

        if ($form3->isSubmitted() && $form3->isValid()) {
        
          $activite->setNiNineaproposition($niNineaproposition);
          if(count($niNineaproposition->getNinActivites())>0)
          $activite->setStatActivPrincipale(false);
          else
          $activite->setStatActivPrincipale(true);
           
          $entityManager->persist($activite);
          $entityManager->flush();

          return $this->redirectToRoute('ni_nineaproposition_show', ['id'=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
          
        }

        return $this->render('ni_nineaproposition/activites.html.twig', [
           'form3' => $form3->createView(),
           'naemas' => $naemas,
           'niNineaproposition' => $niNineaproposition,
          
        ]);
    }


   /**
     * @Route("/recherche", name="ni_nineaproposition_recherche", methods={"GET"})
     */
    public function recherche(NiNineapropositionRepository $niNineapropositionRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
      
      $niNineaproposition = new NiNineaproposition();

      $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
      $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();
      $numdemande ="";
        if ($request->get('numdemande')) 
        {
            $numdemande = $request->get('numdemande');
            $formeunite =  $request->get("formeunite");
            if($request->get("formejuridique"))
              $formejuridique = $entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique"));
              else 
              $formejuridique =null;

            //$formeunite = $entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique"))->getNiFormeunite()->getId();
            $statut = $entityManager->getRepository(NiStatut::class)->find($request->get("statut"));

            $niNineaproposition  = $entityManager->getRepository(NiNineaproposition::class)
                                  ->findBy(
                                    ['ninnumerodemande'  => $numdemande],
                                    // ['nin_formejuridique_id' => $formejuridique ],
                                    // ['nin_statut_id' => $statut ],
                          );
                          //findBy(array("nineaproposition"=>$niNineaproposition),array('created_at'=>'desc'),1,0);
             return $this->render('ni_nineaproposition/recherche.html.twig', [
                            'ni_nineapropositions' => $niNineapropositionRepository->findAll(),
                            'niNineaproposition' => $niNineaproposition,
                            'formeunites' => $formeunites,
                            'ninnumerodemande' => $numdemande,
                            'formejuridiques' => $formejuridiques,                            
                        ]);
            
                  } 

        return $this->render('ni_nineaproposition/recherche.html.twig', [
            'ni_nineapropositions' => $niNineapropositionRepository->findAll(),
            'niNineaproposition' => $niNineaproposition,
            'formeunites' => $formeunites,
            'formejuridiques' => $formejuridiques,
            'ninnumerodemande' => $numdemande,

        ]);
    }


    //controle sur le formulaire personne physique
     /**
     * @Route("/controleCNI/{id}", name="controleCNI",  methods={"GET","POST"})
     */
    public function controlePersonnephysique()
    {

      //$controleCni =   $this->getDoctrine()->getRepository(NiPersonne::class)->findBy(['ninCNI' => $id]);
      $controleCni = $this->getDoctrine()->getRepository(NINinea::class)->findPersonneByNinea($id);
      if (count($controleCni) > 0)
      {
        return  new JsonResponse( 1);
      } 

      else 
      {
         
        $cni11 =  substr($id, 0, 4).substr($id,6, 7);
        $controleCni =   $this->getDoctrine()->getRepository(NiPersonne::class)->findBy(['ninCNI' => $cni11]);
        if (count($controleCni) > 0)
         {
            return  new JsonResponse(  1);
          } else  
            return new JsonResponse(  0);
       }
    }



     /**
     * @Route("/soumission/{id}", name="ni_nineaproposition_soumission", methods={"GET", "POST"})
     */
    public function soumission(Request $request, EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition): Response

      {

         $niNineaproposition->setStatut("c");    
                  $niNineaproposition->setNinlock(false);     
                  $entityManager->flush();

                  return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
          
      }




   /**
    * @Route("/verification/{id}", name="ni_nineaproposition_verification", methods={"GET", "POST"})
    */
   public function verifierPersonne(Request $request, EntityManagerInterface $entityManager, NINinea $ninea): Response

   {
      $personnes = $ninea->getNiPersonne();
      
      $prenom = $request->get("prenom");
      $nom = $request->get("nom");
      $datenaissance = $request->get("datenais");
   
      
      $entityManager->flush();

      return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
   }

       /**
     * @Route("/validation/{id}", name="ni_nineaproposition_validation", methods={"GET", "POST"})
     */
    public function valider(Request $request, EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition,  DiversUtils $diversUtils): Response

    {

      $entityManager->getConnection()->beginTransaction();
      try {
        
              $niNineaproposition->setNinlock(false);
              $CompteurNINEA = new CompteurNINEA();

              //validation
              $niNineaproposition->setStatut("v");
              $ninea = new NINinea();

              $ninea->setFormeJuridique($niNineaproposition->getNinFormejuridique());
              //dd($niNineaproposition->getNinStatut());
              $ninea->setNinStatut($niNineaproposition->getNinStatut());
              $ninea->setNinEnseigne($niNineaproposition->getNinEnseigne());
              $ninea->setNinRegcom($niNineaproposition->getNinRegcom());
              $ninea->setNinEtat("1");
              $ninea->setNiTypedocument($niNineaproposition->getNiTypedocument());
              if($niNineaproposition->getNinDatreg())
                $ninea->setNinDatreg($niNineaproposition->getNinDatreg());
               
              $ninea->setNinRaison($niNineaproposition->getNinRaison());

              $ninea->setNinTitrefoncier($niNineaproposition->getNinTitrefoncier());
              $ninea->setNinAgrement($niNineaproposition->getNinAgrement());
              $ninea->setNinArrete($niNineaproposition->getNinArrete());
              $ninea->setNinRecepisse($niNineaproposition->getNinRecepisse());
              if($niNineaproposition->getNinAccord())
                  $ninea->setNinAccord($niNineaproposition->getNinAccord());
              if($niNineaproposition->getNinBordereau())
                    $ninea->setNinBordereau($niNineaproposition->getNinBordereau());
              if($niNineaproposition->getNinBail())     
                  $ninea->setNinBail($niNineaproposition->getNinBail());
                if($niNineaproposition->getNinPermisoccuper())
                    $ninea->setNinPermisoccuper($niNineaproposition->getNinPermisoccuper());
               
              $ninea->setNiPersonne($niNineaproposition->getNiPersonne());
              $ninea->addNiCoordonnee($niNineaproposition->getCoordonnees()[0]);
              //$ninea->addNinActivite($niNineaproposition->getNinActivites()[0]);
              $ninea->setNiLibelleactiviteglobale($niNineaproposition->getNiLibelleactiviteglobale());
              if(count($niNineaproposition->getNiActiviteEconomiques())>0)
                  if($niNineaproposition->getNiActiviteEconomiques()[0]!=null)
                  $ninea->addNinActivitesEconomique($niNineaproposition->getNiActiviteEconomiques()[0]);
                
                foreach ($niNineaproposition->getNinActivites() as $key) {
                  $ninea->addNinActivite($key);
                }
                foreach ($niNineaproposition->getNinproduits() as $key) {
                  $ninea->addNinproduit($key);
                }
                //////////////////////
                foreach ($niNineaproposition->getNinDirigeants() as $key) {
                  $ninea->addNinDirigeant($key);
                }
      
              $ninea->setCreatedBy($this->getUser());
              $ninea->setModifiedBy($this->getUser());
              
              if ($niNineaproposition->getNinStatut()->getId() == 2)
              {
                if(!$niNineaproposition->getNinNinea()){
                    $numNINEA=$diversUtils->genereNumNINET($entityManager, $niNineaproposition->getNinNineamere());
                    $niNineaproposition->setNinNinea($numNINEA);
                    $ninea->setNinNinea($numNINEA);
                    $ninea->setNinNineamere($niNineaproposition->getNinNineamere());

                }else{
                  $ninea->setNinNinea($niNineaproposition->getNinNinea());
                }
              } else 
              
              {
                if(!$niNineaproposition->getNinNinea()){
                    $numNINEA=$diversUtils->genereNumNINEA($entityManager);
                    $niNineaproposition->setNinNinea($numNINEA);
                    $ninea->setNinNinea($numNINEA);
                }else{
                  $ninea->setNinNinea($niNineaproposition->getNinNinea());
                }

              }

              $entityManager->persist($CompteurNINEA);
              $entityManager->persist($ninea);
              
              
              $entityManager->flush();

              $request->getSession()->getFlashBag()->add('message',"NINEA validé avec succes.");
              $entityManager->getConnection()->commit();
              
             return $this->redirectToRoute('num_ninea', ["id"=>$ninea->getId()], Response::HTTP_SEE_OTHER);

                // faire un traitement sur ces objets qui sont à présent lockés
                
          } catch (\Doctrine\ORM\PessimisticLockException $exception) {
                   $entityManager->getConnection()->rollback();
                   throw $exception;
          }

          return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
        }


      /**
     * @Route("/ninea/{id}", name="ni_nineaproposition_ninea", methods={"GET", "POST"})
     */
   
   
     public function ninea(EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition): Response

    {
          $ninea= $entityManager->getRepository(NINinea::class )->findOneBy(["ninNinea"=>$niNineaproposition->getNinNinea()]);
          return $this->redirectToRoute('nininea_show', ["id" => $ninea->getId()], Response::HTTP_SEE_OTHER);
    }



     /**
     * @Route("/rejet/{id}", name="ni_nineaproposition_rejet", methods={"GET", "POST"})
     */
    public function rejeter(Request $request, EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition): Response

      {
        $niNineaproposition->setNinlock(false);

        $niNineaproposition->setNinRemarque($request->get("remarque"));
        $niNineaproposition->setStatut("r")     ;

            $entityManager->flush();
            
            $session = new Session();
        
            $demandes_rejetees = count($entityManager->getRepository(NiNineaproposition::class)->findByDemande($this->getUser(), 'r'));
            
            $session->set("rejeter", $demandes_rejetees);

            
            return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
          
      }


         /**
     * @Route("/retourner/{id}", name="ni_nineaproposition_retourner", methods={"GET", "POST"})
     */
    
     public function retourner(Request $request, EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition): Response

    {
      $niNineaproposition->setNinlock(false);

      $niNineaproposition->setNinRemarque($request->get("remarque"));
      $niNineaproposition->setStatut("t")     ;

          $entityManager->flush();
          
          $session = new Session();
      
          $demandes_rejetees = count($entityManager->getRepository(NiNineaproposition::class)->findByDemande($this->getUser(), 't'));
          
          $session->set("retourner", $demandes_rejetees);
          
          return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
        
    }

          /**
     * @Route("/editPersonne/{id}/{idDemande}", name="ni_nineaproposition_editPersonne", methods={"GET", "POST"})
     */
    public function editPersonne(Request $request, EntityManagerInterface $entityManager,$id="",$idDemande=""): Response
    {
        $lastpersonne=  $entityManager->getRepository(NiPersonne::class)->find($id);
        $niNineaproposition=  $entityManager->getRepository(NiNineaproposition::class)->find($idDemande);
        
        $nom = $lastpersonne->getNinNom() ;
        $prenom =  $lastpersonne->getNinPrenom()   ;
        //$adresse =   $lastpersonne[0]->getAdresse()  ;

        if ( $lastpersonne->getCivilite()) {
           $civilite =  $lastpersonne->getCivilite()->getId() ;
        }else
            $civilite ="" ;

         if ( $lastpersonne->getNinDateNaissance())
           $datenais =   $lastpersonne->getNinDateNaissance()->format("Y-m-d");
         else
            $datenais = "";

         if ( $lastpersonne->getNationalite())
            $nationalite =  $lastpersonne->getNationalite()->getId();
          else
            $nationalite = "";

          if ( $lastpersonne->getNinSexe())
            $nsexe =  $lastpersonne->getNinSexe()->getId()    ;
          else
           $nsexe = "";

          if ( $lastpersonne->getNinDateCNI())
              $datecni =  $lastpersonne->getNinDateCNI()->format("Y-m-d");
          else
              $datecni = "";
              $datepassport = "";

          //QVH POUR PERSONNE
          if ( $lastpersonne->getNinQvh()) {
            $qvh_personne = $lastpersonne->getNinQvh();
          }else
              $qvh_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
            $cacr_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getId();
          }else
            $cacr_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
            $cav_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getId();
          }else
              $cav_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
              $departement_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getId();
          }else
              $departement_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
             $region_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getId();
          }else
              $region_personne ="" ;


        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();

        $lieunais =   $lastpersonne->getNinLieuNaissance();
        $cni =  $lastpersonne->getNinCNI() ;
        $passport =  $lastpersonne->getNinCNI();
        $raison =  $lastpersonne->getNinRaison();
        $sigle =  $lastpersonne->getNinSigle();
        $email =  $lastpersonne->getNinEmailPersonnel();
        $voie =  $lastpersonne->getNinVoie();
        $numvoie = $lastpersonne->getNumVoie();
         
        if($lastpersonne->getNinTypevoie())
              $typevoie =  $lastpersonne->getNinTypevoie()->getId();

        else
              $typevoie ="";

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();

        if ($request->get("nom")||$request->get("raison")) {

          $session= new Session();
          $session->set('actived',2);
         
          if ($niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId() == 11 || 
            $niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId() == 12)
            {

              //récupération personne physique
              $nom = $request->get("nom");
              $prenom = $request->get("prenom");
             
              $civilite = $request->get("civilite");
              $datenais = $request->get("datenais");
              $lieunais = $request->get("lieunais");
              $email = $request->get('email');
              $telephone = $request->get('telephone');
              $nationalite = $request->get("nationalite");
              $typevoie =  $request->get("typevoie");
              $voie =  $request->get("voie");
              $numvoie =  $request->get("numvoie");
              $adresse =  $request->get("adresse");
              $nsexe = $request->get("sexe");
               $qvh = $request->get("qvh");

              $lastpersonne->setNinNom($nom);
              $lastpersonne->setNinPrenom($prenom);
              $lastpersonne->getNinTelephone($telephone);
              $lastpersonne->setNinEmailPersonnel($email);
              $lastpersonne->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
              $lastpersonne->setNinVoie($voie);
              $lastpersonne->setNumVoie($numvoie);
              $lastpersonne->setAdresse($adresse);              
              $lastpersonne->setCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
              $lastpersonne->setNinDateNaissance(new \DateTime($datenais));
              $lastpersonne->setNinLieuNaissance($lieunais);
              $lastpersonne->setNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
              $lastpersonne->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
               $lastpersonne->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh));
               
              if( $nationalite=="07"){
                  $cni = $request->get("cni");
                  $datecni = $request->get("dateCni");
                  $lastpersonne->setNinCNI($cni);
                  $lastpersonne->setNinDateCNI(new \DateTime($datecni));
              }
              else {
                  $passport = $request->get("passport");
                  $datepassport = $request->get("datepassport");
                  $lastpersonne->setNinCNI($passport);
                  $lastpersonne->setNinDateCNI(new \DateTime($datepassport));
              }

               $lastpersonne->setNinRaison("");
               $lastpersonne->setNinSigle("");

            }
            else
            {
                  //recupération personne morale
                  $raisonsociale = $request->get("raison");
                  $siglesociale = $request->get("sigle");
                  $lastpersonne->setNinRaison($raisonsociale);
                  $lastpersonne->setNinSigle($siglesociale);

            }


                $entityManager->flush();

           // $request->getSession()->getFlashBag()->add('message',"L'activité  a été modifiée avec succés.");

            return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_nineaproposition/editPersonne.html.twig', [
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'lastpersonne' => $lastpersonne,
          
            'nom' => $nom,
            'prenom' => $prenom,
            'civilite' => $civilite,
            'datenais' => $datenais,
            'lieunais' => $lieunais,
            'nationalite' => $nationalite,
            'nsexe' => $nsexe,
            'cni' => $cni,
            'dateCni' => $datecni,
            'passport' => $passport,
            'datepassport' => $datepassport,
            'raison' => $raison,
            'sigle' => $sigle,
            'sexe'=> $sexe,
            'email' => $email,
            'typevoie' => $typevoie,
            'voie' => $voie,
            'numvoie' => $numvoie,

            'typevoies' => $typevoies,
            'regions'=>$regions,
            'region_personne' => $region_personne,
            'departements'=>$departements,
            'departement_personne' => $departement_personne,
            'cavs'=>$cavs,
            'cav_personne' => $cav_personne,
            'cacrs'=>$cacrs,
            'cacr_personne' => $cacr_personne,
            'qvh_personne' => $qvh_personne,
           
           
        ]);
    }



     /**
     * @Route("/editCoordonnees/{id}", name="ni_nineaproposition_editCoordonnees", methods={"GET", "POST"})
     */
    public function editCoordonnees(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

        $coordonnee=$entityManager->getRepository(NiCoordonnees::class)->find($id);
        
        if ($request->get('editer')) 
        {
          $session=new Session();
          $session->set('actived',3);
        
          $typevoie = $request->get("typevoie");
          $qvh =  $request->get("qvh");
          $numvoie = $request->get("numvoie");
          $voie = $request->get("voie");
          $adresse1 = $request->get("adresse1");
          $telephone1 = $request->get("telephone1");
          $telephone2 = $request->get("telephone2");
          $email = $request->get("email");
          $boitepostale =  $request->get("bp");   
          $url =  $request->get("url");   

          $coordonnee->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
          $coordonnee->setNinVoie($voie);
          $coordonnee->setNinnumVoie($numvoie);
          $coordonnee->setNinadresse1($adresse1);
          $coordonnee->setNintelephon2($telephone2);
          $coordonnee->setNinTelephon1($telephone1);
          $coordonnee->setNinEmail($email);
          $coordonnee->setQvh($entityManager->getRepository(QVH::class)->find($qvh));
          $coordonnee->setNinBP($boitepostale);
          $coordonnee->setNinUrl($url);

          $coordonnee->setUpdateBy($this->getUser());

          $entityManager->flush();

         // $request->getSession()->getFlashBag()->add('message',"Les coordonnées ont été  modifiées avec succés.");

            return $this->redirectToRoute('ni_nineaproposition_show', [
              'id'=>$coordonnee->getNiNineaproposition()->getId(), 
            
            ], Response::HTTP_SEE_OTHER);
          
        }

        return $this->renderForm('ni_nineaproposition/editCoordonnee.html.twig', [
           

        ]);
    }


    /**
     * @Route("/editActivites/{id}", name="ni_nineaproposition_editActivites", methods={"GET", "POST"})
     */
    public function editActivites(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {
      
        $lastactivites=$entityManager->getRepository(NiActivite::class)->find($id);
        $form = $this->createForm(NiActiviteType::class, $lastactivites);
       
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
            $session=new Session();

            if ($lastactivites->getNiNineaproposition()->getNinFormejuridique()->getNiFormeunite()->getId() == "11"  or $lastactivites->getNiNineaproposition()->getNinFormejuridique()->getNiFormeunite()->getId() == "12")
            {
              $session->set('actived',5);
            }else
            $session->set('actived',4);

            $entityManager->flush();

            $request->getSession()->getFlashBag()->add('message',"L'activité  a été modifiée avec succés.");

            return $this->redirectToRoute('ni_nineaproposition_show', ["id"=> $lastactivites->getNiNineaproposition()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_nineaproposition/editActivite.html.twig', [
            'form' => $form,     

        ]);
    }


     /**
     * @Route("/tracerDirigeant/{id}", name="tracerDirigeant", methods={"GET", "POST"})
     */
    public function tracerDirigeant(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {

      $lastdirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
      dump_sql($lastdirigean);
    
      $nom = $lastdirigeant->getNinNom();
      $prenom = $lastdirigeant->getNinPrenom();

      $cni = $lastdirigeant->getNinCni();

      if ($request->get("quitter")) 
      {   

        return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$lastdirigeant->getNinNineaProposition()->getId()], Response::HTTP_SEE_OTHER);
      }

      $personnePhysiques = $entityManager->getRepository(NiPersonne::class)->findBy(array("ninCNI"=>$cni));
      $dirigeants = $entityManager->getRepository(NiDirigeant::class)->findBy(array("ninCni"=>$cni));
      //var_dump($personnePhysiques);
      return $this->renderForm('ni_nineaproposition/traceDirigeant.html.twig', [
            
        'personnePhysiques' => $personnePhysiques,
        'dirigeants' => $dirigeants,
        'prenom' => $prenom,
        'nom' => $nom,
       
       
    ]);

    }


          /**
     * @Route("/editDirigeant/{id}", name="ni_nineaproposition_editDirigeant", methods={"GET", "POST"})
     */
    public function editDirigeant(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
     
      $lastdirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
         
        $telephone1 = $lastdirigeant->getNinTelephone1();
        $telephone2 = $lastdirigeant->getNinTelephone2();
        $email = $lastdirigeant->getNinEmail();
        $nom = $lastdirigeant->getNinNom();
        $prenom = $lastdirigeant->getNinPrenom();

        if ( $lastdirigeant->getNinCivilite()) {
           $civilite =  $lastdirigeant->getNinCivilite()->getId() ;
        }else
            $civilite ="" ;

         if ( $lastdirigeant->getNinDatenais())
           $datenais =   $lastdirigeant->getNinDatenais()->format("Y-m-d");
         else
            $datenais = "";

         if ( $lastdirigeant->getNinNationalite())
            $nationalite =  $lastdirigeant->getNinNationalite()->getId();
          else
            $nationalite = "";

          if ( $lastdirigeant->getNinSexe())
            $nsexe =  $lastdirigeant->getNinSexe()->getId()    ;
          else
           $nsexe = "";


           if ( $lastdirigeant->getNinDateCni())
              $datecni =  $lastdirigeant->getNinDateCni()->format("Y-m-d");
          else
              $datecni = "";
              $datepassport = "";

          if ($lastdirigeant->getNinPosition()) 
         
            $qualification = $lastdirigeant->getNinPosition()->getId();
          else
            $qualification = "";

            //QVH POUR PERSONNE
          if ( $lastdirigeant->getNinQvh()) {
            $qvh_dirig = $lastdirigeant->getNinQvh();
          }else
              $qvh_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
            $cacr_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getId();
          }else
            $cacr_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
            $cav_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getId();
          }else
              $cav_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
              $departement_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getId();
          }else
              $departement_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
             $region_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getId();
          }else
              $region_dirig ="" ;

        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
      
        $lieunais =   $lastdirigeant->getNinLieunais();
        $cni =  $lastdirigeant->getNinCni() ;
        $passport =  $lastdirigeant->getNinCni();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();

        $regions = $entityManager->getRepository(Region::class)->findAll();


        if ($request->get("editer")) 

          {  
              $session=new Session();
              $session->set('actived',4);            
              $civilite = $request->get("civilite");
              $qualification = $request->get("qualification");
              $datenais = $request->get("datenais");
              $lieunais = $request->get("lieunais");
              $email = $request->get('email');
              $telephone1 = $request->get('telephone1');
              $telephone2 = $request->get('telephone2');
              $prenom = $request->get('prenom');
              $nom = $request->get('nom');
              $nationalite = $request->get("nationalite");
              $nsexe = $request->get("sexe");
          
              $qvh = $request->get("qvh_dirig"); 

              $lastdirigeant->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh));
              $lastdirigeant->setNinPrenom($prenom);
              $lastdirigeant->setNinNom($nom);
              $lastdirigeant->setNinEmail($email);
              $lastdirigeant->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
              $lastdirigeant->setNinDatenais(new \DateTime($datenais));
              $lastdirigeant->setNinLieunais($lieunais);
              $lastdirigeant->setNinTelephone1($telephone1);
              $lastdirigeant->getNinTelephone2($telephone2);

              $lastdirigeant->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
              $lastdirigeant->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
              $lastdirigeant->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualification));

              if( $nationalite=="SN"){
                  $cni = $request->get("cni");
                  $datecni = $request->get("dateCni");
                  $lastdirigeant->setNinCni($cni);
                  $lastdirigeant->setNinDateCni(new \DateTime($datecni));
              }
              else {
                  $passport = $request->get("passport");
                  $datepassport = $request->get("datepassport");
                  $lastdirigeant->setNinCni($passport);
                  $lastdirigeant->setNinDateCni(new \DateTime($datepassport));
              }

              $lastdirigeant->setCreatedBy($this->getUser());
              $lastdirigeant->setModifiedBy($this->getUser());

            $entityManager->flush();

           // $request->getSession()->getFlashBag()->add('message',"Le dirigeant  a été modifié avec succés.");


            return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$lastdirigeant->getNinNineaProposition()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_nineaproposition/editDirigeant.html.twig', [
            
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'lastdirigeant' => $lastdirigeant,
          
            'qualification' => $qualification,
            'qualifications' => $qualifications,
            'civilite' => $civilite,
            'datenais' => $datenais,
            'lieunais' => $lieunais,
            'nationalite' => $nationalite,
            'nsexe' => $nsexe,
            'cni' => $cni,
            'dateCni' => $datecni,
            'passport' => $passport,
            'datepassport' => $datepassport,
            'sexe'=> $sexe,
            'email' => $email,
            'telephone1' => $telephone1,
            'telephone2' => $telephone2,
            'email' => $email,
            'prenom' => $prenom, 
            'nom' => $nom,

            'region_dirig' => $region_dirig,
            'departement_dirig' => $departement_dirig,
            'cav_dirig' => $cav_dirig,
            'cacr_dirig' => $cacr_dirig,
            'qvh_dirig' => $qvh_dirig,
            'regions'=>$regions,
            'departements'=>$departements,
            'cavs'=>$cavs,
            'cacrs'=>$cacrs,
           
           
        ]);
    }

    /**
     * @Route("/modifierEntete/{id}", name="modifierEntete", methods={"GET", "POST"})
     */
    public function modifierEntete(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

      $niNineaproposition= $entityManager->getRepository(NiNineaproposition::class)->find($id);

     // var_dump($niNineaproposition);


      $niNineaproposition->setNinmajdate(new \DateTime());

      $session=new Session();
      $session->set('actived',"");
      
       $ninRegcom = "";
       $ninDatreg = "";

      if ($request->get('modifierEntete')) {


          if ($request->get('ninStatut') == 2)
          {
            
            $nineamere = $request->get('nineamere');
            $siglemere = $request->get('siglemere');

            $niNineaproposition->setNinSiglemere($siglemere);
            $niNineaproposition->setNinNineamere($nineamere);
          }

          $niNineaproposition->setUpdatedBy($this->getUser());

          $ninEnseigne = $request->get('ninEnseigne');
          $ninDatreg = $request->get('ninDatreg');
          $ninRegcom= $request->get('ni_nineaproposition_ninRegcom');

          $niNineaproposition->setNinEnseigne($ninEnseigne);
          $niNineaproposition->setNinDatreg(new \DateTime($ninDatreg));
          $niNineaproposition->setNinRegcom( str_replace("_","",$ninRegcom));

         
          $entityManager->flush();

          return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
        }
        else if ($request->get('reprendre')) {
          $personne = $niNineaproposition->getNiPersonne();
          $coordonnee = $niNineaproposition->getCoordonnees()[0];
          $activite_economique = $niNineaproposition->getNiActiviteEconomiques()[0];
  
          if($personne){
            $entityManager->remove($personne);
          }
          if($coordonnee){
            $entityManager->remove($coordonnee);
          }
          if($activite_economique){
            $entityManager->remove($activite_economique);
          }
  
          foreach ($niNineaproposition->getNinActivites() as $key) {
            $entityManager->remove($key);
          }
          foreach ($niNineaproposition->getNinDirigeants() as $key) {
            $entityManager->remove($key);
          }
          foreach ($niNineaproposition->getNinproduits() as $key) {
            $entityManager->remove($key);
          }
  
          $entityManager->remove($niNineaproposition);
          $entityManager->flush();
  
  
          return $this->redirectToRoute('ni_nineaproposition_new', [], Response::HTTP_SEE_OTHER);
        }

    }


    /**
     * @Route("/editActivitesEconomiques/{id}", name="ni_nineaproposition_editActivitesEconomiques", methods={"GET", "POST"})
     */
    public function editActivitesEconomiques(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {
            
      $acteconom=$entityManager->getRepository(NiActiviteEconomique::class)->find($id);
        
        if ($request->get('modifierActivitesEcos')) 
        {
          if ($acteconom->getNiNineaproposition()->getNinFormejuridique()->getNiFormeunite()->getId() == 11 or 
            $acteconom->getNiNineaproposition()->getNinFormejuridique()->getNiFormeunite()->getId() == 12)
          {
            $session= new Session();
            $session->set('actived',"4");
          }
          else 
          {
            $session= new Session();
            $session->set('actived',5);
          }

          $ninAffaire = str_replace(" ", "", $request->get("ninAffaire"));
          $ninAnneeCa =  $request->get("ninAnneeCa");
          $ninCapital = $request->get("ninCapital");
          $ninEffectif = $request->get("ninEffectif");
          $ninEffect1 = $request->get("ninEffect1");
          $ninEffectifFem = $request->get("ninEffectifFem");
          $ninEffectifFemSAIS = $request->get("ninEffectifFemSAIS");

          if($ninAffaire){
            $acteconom->setNinAffaire($ninAffaire);
          }
          if($ninAnneeCa){
            $acteconom->setNinAnneeCa($ninAnneeCa);
          }
          if($ninCapital){
            $acteconom->setNinCapital($ninCapital);
          }
          if($ninEffectif){
            $acteconom->setNinEffectif($ninEffectif);
          }

          if($ninEffect1){
            $acteconom->setNinEffect1($ninEffect1);
          }
          if($ninEffectifFem){
            $acteconom->setNinEffectifFem($ninEffectifFem);
          }
          if($ninEffectifFemSAIS){
            $acteconom->setNinEffectifFemSAIS($ninEffectifFemSAIS);
          }




          $entityManager->flush();

         // $request->getSession()->getFlashBag()->add('message',"L'activité économique  a été modifiée avec succés.");

            return $this->redirectToRoute('ni_nineaproposition_show', [
              'id'=>$acteconom->getNiNineaproposition()->getId(), 
              
            
            ], Response::HTTP_SEE_OTHER);
          
        }

        return $this->renderForm('ni_nineaproposition/editActivitesEconomiques.html.twig', [
           

        ]);

     }

     

     /**
     * @Route("/newAncienNINEA", name="ni_nineaproposition_newAncienNINEA", methods={"GET", "POST"})
     */
    
     public function newAncienNINEA(Request $request, EntityManagerInterface $entityManager, DiversUtils $diversUtils): Response
    {

        $niNineaproposition = new NiNineaproposition();
        $niNineaproposition->setNinmajdate(new \DateTime());

        $session=new Session();
        $session->set('actived',"");

        $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
        $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();

        $form = $this->createForm(NiNineapropositionAncienNINEAType::class, $niNineaproposition);
        $form->handleRequest($request);
        
         $ninRegcom = "";
         $ninDatreg = "";

        if ($form->isSubmitted() && $form->isValid()) {

            $CompteurDemandeNINEA = new CompteurDemandeNINEA();

            if ($form['ninStatut']->getData()->getId() == 2)
            {
              $nineamere = $request->get('nineamere');
              $siglemere = $request->get('siglemere');

              $niNineaproposition->setNinSiglemere($siglemere);
              $niNineaproposition->setNinNineamere($nineamere);
            }

            if($request->get('inputenseigne'))
              $niNineaproposition->setNinEnseigne( $request->get('inputenseigne'));

               //$formeunite = $entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique"))->getNiFormeunite()->getId();
            $niNineaproposition->setNinFormejuridique($entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique")));

            if ($request->get("formejuridique") == 10)
            {

               $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
               $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));

            } 
            else if ($request->get("formejuridique") == 92) {
              $niNineaproposition->setNinBordereau($request->get('inputbordereau'));

            }  
            else if ($request->get("formejuridique") == 91 
                or $request->get("formejuridique") == 29) 
            {
              $niNineaproposition->setNinBordereau($request->get('inputbordereau'));
              $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
              $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));

            } 
            else if ($request->get("formejuridique") == 26 
              or $request->get("formejuridique") == 96 or $request->get("formejuridique") == 99) 
              {
              $niNineaproposition->setNinTitrefoncier($request->get('titrefoncier'));
              $niNineaproposition->setNinBail($request->get('inputbail'));

            } 
             else if ($request->get("formejuridique") == 90) {
              $niNineaproposition->setNinAccord($request->get('inputaccord'));
            }  
            else if ($request->get("formejuridique") == 44 
              or $request->get("formejuridique") == 48) {
              $niNineaproposition->setNinAgrement($request->get('inputagrement'));
            } 
            else if ($request->get("formejuridique") == 27) {
              $niNineaproposition->setNinAgrement($request->get('inputagrement'));
              $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
              $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));
            } 
            else if ($request->get("formejuridique") == 50 or $request->get("formejuridique") == 51  
                or $request->get("formejuridique") == 52 or $request->get("formejuridique") == 54  or  $request->get("formejuridique") == 55 or $request->get("formejuridique") == 59) 
            {
              $niNineaproposition->setNinRecepisse($request->get('inputrecepisse'));
            } 
            else if ($request->get("formejuridique") == 32 or $request->get("formejuridique") == 45 
               or $request->get("formejuridique") == 42  or  $request->get("formejuridique") == 43  or $niNineaproposition->getNinFormejuridique()->getId() == 46  or $niNineaproposition->getNinFormejuridique()->getId() == 47  or $niNineaproposition->getNinFormejuridique()->getId() == 56
                or $request->get("formejuridique") == 97  or $request->get("formejuridique") == 95) 
              {
                $niNineaproposition->setNinArrete($request->get('inputarrete'));
                //dd($request->get('inputarrete'));
              } 
            else
            {
              $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
              $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));

            }


            $niNineaproposition->setCreatedBy($this->getUser());
            $niNineaproposition->setUpdatedBy($this->getUser());

            //generer le code de numéro de demande
            $numDemande=$diversUtils->numDemandeSuivant($entityManager);
            $niNineaproposition->setNinnumerodemande($numDemande);
            $niNineaproposition->setStatut("b");

            $entityManager->persist($niNineaproposition);
            $entityManager->persist($CompteurDemandeNINEA);
            $entityManager->flush();


              return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
          }

              return $this->renderForm('ni_nineaproposition/new_ancienNINEA.html.twig', [
              'ni_nineaproposition' => $niNineaproposition,
              'form' => $form,
              'formeunites' => $formeunites,
             
              'formejuridiques' => $formejuridiques,
                       
              'ninRegcom' => $ninRegcom,
              'ninDatreg' => $ninDatreg,
          

        ]);
    }


     /**
     * @Route("/controleCNI/{id}", name="controleCNI",  methods={"GET","POST"})
     */
    public function controleCNI( $id = "")
    {

      //$controleCni =   $this->getDoctrine()->getRepository(NiPersonne::class)->findBy(['ninCNI' => $id]);
      $controleCni = $this->getDoctrine()->getRepository(NINinea::class)->findPersonneByNinea($id);
      if (count($controleCni) > 0)
      {
        return  new JsonResponse( 1);
      } 

      else 
      {
         
        $cni11 =  substr($id, 0, 4).substr($id,6, 7);
        $controleCni =   $this->getDoctrine()->getRepository(NiPersonne::class)->findBy(['ninCNI' => $cni11]);
        if (count($controleCni) > 0)
         {
            return  new JsonResponse(  1);
          } else  
            return new JsonResponse(  0);
       }
    }


    
     /**
     * @Route("/controleRCCM/{id}", name="controleRCCM",  methods={"GET","POST"})
     */
    public function controleRCCM( $id = "")
    {
      $controleRccm =  $this->getDoctrine()->getRepository(NINinea::class)->findninRegcom($id);
      //$rccm = preg_replace('/\s+/', '', $controleRccm);
    
      if (count($controleRccm) > 0)
      {        
        return  new JsonResponse(1);
      } 
      else 
      {
          return new JsonResponse(0);
      }
    }



      /**
     * @Route("/controleRaison/{id}", name="controleRaison",  methods={"GET","POST"})
     */
    public function controleRaison( $id = "")
    {
      $controleRaison =  $this->getDoctrine()->getRepository(NiPersonne::class)->findBy(['ninRaison' => $id]);
      
      if (count($controleRaison) > 0)
      {        
        return  new JsonResponse(1);
      } 
      else 
      {
          return new JsonResponse(0);
      }
    }


  /**
     * @Route("/controleCNIDIRIG/{id}", name="controleCNIDIRIG",  methods={"GET","POST"})
     */
    public function controleCNIDIRIG( $id = "")
    {

      $controleCni =   $this->getDoctrine()->getRepository(NiDirigeant::class)->findBy(['ninCni' => $id]);

      if (count($controleCni) > 0)
      {
        return  new JsonResponse( 1);
      } 

      else 
      {
         
        $cni11 =  substr($id, 0, 4).substr($id,6, 7);
        $controleCni =   $this->getDoctrine()->getRepository(NiDirigeant::class)->findBy(['ninCni' => $cni11]);
        if (count($controleCni) > 0)
         {
            return  new JsonResponse(  1);
          } else  
            return new JsonResponse(  0);
       }
    }



    public function controlesRCCM( $registre = "", $dateregistre)
    {

     
               //RCCM: SNDKR2000A22222
               $rccm =  str_replace(" ","",$registre) ;
               $rccmNormal = str_replace("_","",$rccm);
               //$dateReg = $niNineaproposition->getNinRegcom();
               $pays = substr($rccmNormal, 0, 2);
               $juridiction = substr($rccmNormal, 2, 3);
               $annee = substr($rccmNormal, 5, 4);
               $lettrecle = substr($rccmNormal, 9, 1);
               $sequence = substr($rccmNormal, 10, 5);
               $annee_cours = date("Y");
               $controleRccm =  $this->getDoctrine()->getRepository(NINinea::class)->findninRegcom($rccmNormal);
               $datereg = $dateregistre;
               $datereg_annee =  date('Y', strtotime($datereg));
               //dd($controleRccm);
               $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(A|B|C|E)(\d{1,5})$/"; 
               $dateJour = date('Y-m-d');


    }
   
    /**
     * @Route("/new", name="ni_nineaproposition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, DiversUtils $diversUtils): Response
    {

        $niNineaproposition = new NiNineaproposition();
        $niNineaproposition->setNinmajdate(new \DateTime());

        $session=new Session();
        $session->set('actived',"");

        $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
        $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();
        $typedocuments = $entityManager->getRepository(NinTypedocuments::class)->findAll();

        $form = $this->createForm(NiNineapropositionType::class, $niNineaproposition);
        $form->handleRequest($request);
        
         $ninRegcom = "";
         $ninDatreg = "";

         $ninineamere = null;

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $CompteurDemandeNINEA = new CompteurDemandeNINEA();

            if ($form['ninStatut']->getData())
            {
               if ($form['ninStatut']->getData()->getId() == 2)
               {
                 
                 $nineamere = $request->get('nineamere');
                 $siglemere = $request->get('siglemere');
   
                 $niNineaproposition->setNinSiglemere($siglemere);
                 $niNineaproposition->setNinNineamere($nineamere);
   
                 $ninineamere =  $entityManager->getRepository(NINinea::class)->findBy(['ninNinea' => $nineamere]);
   
               }
               
            }
         
               //$formeunite = $entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique"))->getNiFormeunite()->getId();
               $niNineaproposition->setNinFormejuridique($entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique")));
               $niNineaproposition->setCreatedBy($this->getUser());
               $niNineaproposition->setUpdatedBy($this->getUser());

               //generer le code de numéro de demande
               $numDemande=$diversUtils->numDemandeSuivant($entityManager);
               $niNineaproposition->setNinnumerodemande($numDemande);
               $niNineaproposition->setStatut("b");
               $niNineaproposition->setNinEnseigne($request->get('inputenseigne'));

               //RCCM: SNDKR2000A22222
               $rccm =  str_replace(" ","",$request->get("registreCommerce")) ;
               $rccmNormal = str_replace("_","",$rccm);
               //$dateReg = $niNineaproposition->getNinRegcom();
               $pays = substr($rccm, 0, 2);
               $juridiction = substr($rccm, 2, 3);
               $annee = substr($rccm, 5, 4);
               $lettrecle = substr($rccm, 9, 1);
               $sequence = substr($rccm, 10, 5);
               $annee_cours = date("Y");
               $controleRccm =  $this->getDoctrine()->getRepository(NINinea::class)->findninRegcom($rccmNormal);
               $datereg = $request->get("dateregcom");
               $datereg_annee =  date('Y', strtotime($datereg));
               //dd($controleRccm);
               $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(A|B|C|E)(\d{1,5})$/"; 
               $dateJour = date('Y-m-d');
               $pattern = "/(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR|[A-Z]{3})(\d{4})(A|B|C|E|[A-Z]{1})(\d{1,5})$/"; 

               $ninFormeunite = $niNineaproposition->getNinFormejuridique()->getNiFormeunite();
               $ninFormejuridique = $niNineaproposition->getNinFormejuridique();
               $ninStatut = $niNineaproposition->getNinStatut();
               $enseigne = $niNineaproposition->getNinEnseigne();

            if ($niNineaproposition->getNinFormejuridique()->getId() == 10)
            {  
               //$niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
               //$niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));

               
               if (count($controleRccm) > 0)
                  {
                       $request->getSession()->getFlashBag()->add('messageDoublons',"Ce registre de commerce existe déjà.");
                       //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                       return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,    
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),

                        'ni_nineaproposition_mere' => $ninineamere,
                       
                     ]);

                  }
                    
               elseif (preg_match($pattern_rccm, $rccmNormal) == 0) 
               {
                    
                     $request->getSession()->getFlashBag()->add('messageFormat',"Format invalide pour le registre de commerce.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,                       
                     'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);

               }

               elseif($annee > $annee_cours)
               {
                  
                  $request->getSession()->getFlashBag()->add('messageDate',"La date de création du registre ne doit pas être postérieure à l'année en cours.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                  'ni_nineaproposition' => $niNineaproposition,
                  'form' => $form,
                  'formeunites' => $formeunites,             
                  'formejuridiques' => $formejuridiques,                       
                  'ninFormeJuridique' => $ninFormejuridique,
                  'ninFormeunite' => $ninFormeunite,
                  'ninStatut' => $ninStatut,
                  'ninEnseigne' => $enseigne,
                  'ninRegcom' => $request->get("registreCommerce"),
                  'ninDatereg' => $request->get("dateregcom"),
                  'ni_nineaproposition_mere' => $ninineamere,
                  
                  ]);
               }
               elseif($annee < "1900")
               {
                  
                  $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à l'année 1900.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                  'ni_nineaproposition' => $niNineaproposition,
                  'form' => $form,
                  'formeunites' => $formeunites,             
                  'formejuridiques' => $formejuridiques,                       
                  'ninFormeJuridique' => $ninFormejuridique,
                  'ninFormeunite' => $ninFormeunite,
                  'ninStatut' => $ninStatut,
                  'ninEnseigne' => $enseigne,
                  'ninRegcom' => $request->get("registreCommerce"),
                  'ninDatereg' => $request->get("dateregcom"),
                  'ni_nineaproposition_mere' => $ninineamere,
                  
                  ]);
               }
               elseif ($datereg > $dateJour)
               {
                  $request->getSession()->getFlashBag()->add('messageDateJour',"La date du registre ne doit pas être postérieure à la date du jour.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,                       
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               elseif ($datereg_annee < $annee)
               {
                  //dd($datereg_annee);
                  $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à la date de création sur le registre.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,                       
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else
               {
                  $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
                  $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));
                  $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(1));

               }
            
            } 
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 92) {
               $bordereau = trim($request->get('inputbordereau'));
               $controleBordereau =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninBordereau' => $bordereau]);

               if (preg_match($pattern, $bordereau) == 1)
               {
                  $request->getSession()->getFlashBag()->add('message',"Le format du bordereau n'est pas valide.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,                       
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninBordereau' => $request->get("inputbordereau"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else if (count($controleBordereau) > 0)
               {
                     $request->getSession()->getFlashBag()->add('messageDoublons',"Ce bordereau existe déjà.");
                     //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,    
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninBordereau' => $request->get("inputbordereau"),

                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else 
               {
                  $niNineaproposition->setNinBordereau($request->get('inputbordereau'));
                  $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(2));

               }
               
            }  
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 91 
                or $niNineaproposition->getNinFormejuridique()->getId() == 29) 
            {
               $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find($request->get('typedocuments')));
               if($request->get('typedocuments') != 1)
                  {
                     $bordereau = $request->get('inputbordereau');
                     $controleBordereau =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninBordereau' => $bordereau]);

                     if (preg_match($pattern, $bordereau) == 1)
                     {
                        $request->getSession()->getFlashBag()->add('message',"Le format du bordereau n'est pas valide.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,   
                           'typedocuments'  => $typedocuments,                  
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninBordereau' => $request->get("inputbordereau"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else if (count($controleBordereau) > 0)
                     {
                           $request->getSession()->getFlashBag()->add('messageDoublons',"Ce bordereau existe déjà.");
                           //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';
      
                           return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,    
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'typedocuments'  => $typedocuments,                  
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninBordereau' => $request->get("inputbordereau"),
      
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else 
                     {
                        $niNineaproposition->setNinBordereau($request->get('inputbordereau'));
                        $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(2));

                     }
                     
                  }
               else{ //typedocument = 1
                     if (count($controleRccm) > 0)
                     {
                        $request->getSession()->getFlashBag()->add('messageDoublons',"Ce registre de commerce existe déjà.");
                        //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,    
                           'typedocuments'  => $typedocuments,                  
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninRegcom' => $request->get("registreCommerce"),
                           'ninDatereg' => $request->get("dateregcom"),

                           'ni_nineaproposition_mere' => $ninineamere,
                        
                        ]);

                     }
                     
                     elseif (preg_match($pattern_rccm, $rccmNormal) == 0) 
                     {
                        
                           $request->getSession()->getFlashBag()->add('messageFormat',"Format invalide pour le registre de commerce.");
                           
                           return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,   
                           'typedocuments'  => $typedocuments,                                      
                           'ninFormeJuridique' => $ninFormejuridique,
                              'ninFormeunite' => $ninFormeunite,
                              'ninStatut' => $ninStatut,
                              'ninEnseigne' => $enseigne,
                              'ninRegcom' => $request->get("registreCommerce"),
                              'ninDatereg' => $request->get("dateregcom"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);

                     }

                     elseif($annee > $annee_cours)
                     {
                        
                        $request->getSession()->getFlashBag()->add('messageDate',"La date de création du registre ne doit pas être postérieure à l'année en cours.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,     
                        'typedocuments'  => $typedocuments,                                    
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                        ]);
                     }
                     elseif($annee < "1900")
                     {
                        
                        $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à l'année 1900.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,    
                        'typedocuments'  => $typedocuments,                                     
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                        ]);
                     }
                     elseif ($datereg > $dateJour)
                     {
                        $request->getSession()->getFlashBag()->add('messageDateJour',"La date du registre ne doit pas être postérieure à la date du jour.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,
                           'typedocuments'  => $typedocuments,                                         
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninRegcom' => $request->get("registreCommerce"),
                           'ninDatereg' => $request->get("dateregcom"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     elseif ($datereg_annee < $annee)
                     {
                        //dd($datereg_annee);
                        $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à la date de création sur le registre.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,  
                           'typedocuments'  => $typedocuments,                                       
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninRegcom' => $request->get("registreCommerce"),
                           'ninDatereg' => $request->get("dateregcom"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else
                     {
                        $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
                        $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));
                        $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(1));

                     }
                  
               }
            } 
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 26 
              or $niNineaproposition->getNinFormejuridique()->getId() == 96 or $niNineaproposition->getNinFormejuridique()->getId() == 99) 
              {

               $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find($request->get('typedocuments')));
               if($request->get('typedocuments') == 3)
               {
                     $titrefoncier = trim($request->get('titrefoncier'));
                     $controleTitre =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninTitrefoncier' => $titrefoncier]);

                     //dd(preg_match($pattern, $titrefoncier));

                     if (preg_match($pattern, $titrefoncier) == 1)
                     {
                        $request->getSession()->getFlashBag()->add('messageValide',"Le format du titre foncier n'est pas valide.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,   
                           'typedocuments'  => $typedocuments,                  
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninTitrefoncier' => $request->get("titrefoncier"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else if (count($controleTitre) > 0)
                     {
                           $request->getSession()->getFlashBag()->add('messageDoublons',"Ce titre foncier existe déjà.");
                           //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';
      
                           return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,    
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'typedocuments'  => $typedocuments,                  
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninTitrefoncier' => $request->get("titrefoncier"),
      
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else 
                     {
                        $niNineaproposition->setNinTitrefoncier($request->get('titrefoncier'));
                        $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(3));

                     }

               } else if($request->get('typedocuments') == 4)
               {
                     $bail = trim($request->get('inputbail'));
                     $controleBail =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninBail' => $bail]);

                     if (preg_match($pattern, $bail) == 1)
                     {
                        $request->getSession()->getFlashBag()->add('message',"Le format du bail n'est pas valide.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,   
                           'typedocuments'  => $typedocuments,                  
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninBail' => $request->get("inputbail"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else if (count($controleBail) > 0)
                     {
                           $request->getSession()->getFlashBag()->add('messageDoublons',"Ce bail existe déjà.");
                           //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';
      
                           return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,    
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'typedocuments'  => $typedocuments,                  
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninBail' => $request->get("inputbail"),
      
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else 
                     {
                        $niNineaproposition->setNinBail($request->get('inputbail'));
                        $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(4));

                     }
               }else
               {
                     $permisdoccuper = trim($request->get('inputpermisoccuper'));
                     $controlePermis =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninPermisoccuper' => $permisdoccuper]);

                     if (preg_match($pattern, $permisdoccuper) == 1)
                     {
                        $request->getSession()->getFlashBag()->add('message',"Le format du permis n'est pas valide.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,   
                           'typedocuments'  => $typedocuments,                  
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninPermisdoccuper' => $request->get("inputpermisoccuper"),
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else if (count($controlePermis) > 0)
                     {
                           $request->getSession()->getFlashBag()->add('messageDoublons',"Ce permis existe déjà.");
                           //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';
      
                           return $this->renderForm('ni_nineaproposition/new.html.twig', [
                           'ni_nineaproposition' => $niNineaproposition,
                           'form' => $form,
                           'formeunites' => $formeunites,             
                           'formejuridiques' => $formejuridiques,    
                           'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'typedocuments'  => $typedocuments,                  
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninPermisdoccuper' => $request->get("inputpermisoccuper"),
      
                           'ni_nineaproposition_mere' => $ninineamere,
                           
                        ]);
                     }
                     else 
                     {
                        $niNineaproposition->setNinPermisoccuper($request->get('inputpermisoccuper'));
                        $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(5));

                     }
               }
              
            } 
             else if ($niNineaproposition->getNinFormejuridique()->getId() == 90) {

               $accord = trim($request->get('inputaccord'));
               $controlePermis =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninAccord' => $accord]);

               if (preg_match($pattern, $accord) == 1)
               {
                  $request->getSession()->getFlashBag()->add('message',"Le format de l'accord n'est pas valide.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,   
                     'typedocuments'  => $typedocuments,                  
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninAcccord' => $request->get("inputaccord"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else if (count($controlePermis) > 0)
               {
                     $request->getSession()->getFlashBag()->add('messageDoublons',"Cet accord existe déjà.");
                     //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,    
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'typedocuments'  => $typedocuments,                  
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninAccord' => $request->get("inputaccord"),

                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else 
               {
                  $niNineaproposition->setNinAccord($request->get('inputaccord'));
               }
            }  
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 44      or $niNineaproposition->getNinFormejuridique()->getId() == 48) 
            {
               $agrement = trim($request->get('inputagrement'));
               $controleAgrement =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninAgrement' => $agrement]);

               if (preg_match($pattern, $agrement) == 1)
               {
                  $request->getSession()->getFlashBag()->add('message',"Le format de l'agrément n'est pas valide.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,   
                     'typedocuments'  => $typedocuments,                  
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninAgrement' => $request->get("inputagrement"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else if (count($controleAgrement) > 0)
               {
                     $request->getSession()->getFlashBag()->add('messageDoublons',"Cet agrément existe déjà.");
                     //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,    
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'typedocuments'  => $typedocuments,                  
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninAgrement' => $request->get("inputagrement"),

                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else 
               {
                  $niNineaproposition->setNinAgrement($request->get('inputagrement'));
               }
            } 
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 27) {
               $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find($request->get('typedocuments')));
               if($request->get('typedocuments') == 1)
               {
                  if (count($controleRccm) > 0)
                  {
                     $request->getSession()->getFlashBag()->add('messageDoublons',"Ce registre de commerce existe déjà.");
                     //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,    
                        'typedocuments'  => $typedocuments,                  
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),

                        'ni_nineaproposition_mere' => $ninineamere,
                     
                     ]);

                  }
                  
                  elseif (preg_match($pattern_rccm, $rccmNormal) == 0) 
                  {
                     
                        $request->getSession()->getFlashBag()->add('messageFormat',"Format invalide pour le registre de commerce.");
                        
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,   
                        'typedocuments'  => $typedocuments,                                      
                        'ninFormeJuridique' => $ninFormejuridique,
                           'ninFormeunite' => $ninFormeunite,
                           'ninStatut' => $ninStatut,
                           'ninEnseigne' => $enseigne,
                           'ninRegcom' => $request->get("registreCommerce"),
                           'ninDatereg' => $request->get("dateregcom"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);

                  }

                  elseif($annee > $annee_cours)
                  {
                     
                     $request->getSession()->getFlashBag()->add('messageDate',"La date de création du registre ne doit pas être postérieure à l'année en cours.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,     
                     'typedocuments'  => $typedocuments,                                    
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                     ]);
                  }
                  elseif($annee < "1900")
                  {
                     
                     $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à l'année 1900.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,    
                     'typedocuments'  => $typedocuments,                                     
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                     ]);
                  }
                  elseif ($datereg > $dateJour)
                  {
                     $request->getSession()->getFlashBag()->add('messageDateJour',"La date du registre ne doit pas être postérieure à la date du jour.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,
                        'typedocuments'  => $typedocuments,                                         
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  elseif ($datereg_annee < $annee)
                  {
                     //dd($datereg_annee);
                     $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à la date de création sur le registre.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,  
                        'typedocuments'  => $typedocuments,                                       
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else
                  {
                     $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
                     $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));
                     $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(1));

                  }
               }
               else
               {
                  $agrement = trim($request->get('inputagrement'));
                  $controleAgrement =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninAgrement' => $agrement]);
   
                  if (preg_match($pattern, $agrement) == 1)
                  {
                     $request->getSession()->getFlashBag()->add('message',"Le format de l'agrément n'est pas valide.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,   
                        'typedocuments'  => $typedocuments,                  
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninAgrement' => $request->get("inputagrement"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else if (count($controleAgrement) > 0)
                  {
                        $request->getSession()->getFlashBag()->add('messageDoublons',"Cet agrément existe déjà.");
                        //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';
   
                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,    
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'typedocuments'  => $typedocuments,                  
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninAgrement' => $request->get("inputagrement"),
   
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else 
                  {
                     $niNineaproposition->setNinAgrement($request->get('inputagrement'));
                     $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(6));

                  }
               }
             
            } 
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 50 or $niNineaproposition->getNinFormejuridique()->getId() == 51  
                or $niNineaproposition->getNinFormejuridique()->getId() == 52 or $niNineaproposition->getNinFormejuridique()->getId() == 54  or  $niNineaproposition->getNinFormejuridique()->getId() == 55 or $niNineaproposition->getNinFormejuridique()->getId() == 59) 
            {
               $recepisse= trim($request->get('inputrecepisse'));
               $controleRecepisee =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninRecepisse' => $recepisse]);

               if (preg_match($pattern, $recepisse) == 1)
               {
                  $request->getSession()->getFlashBag()->add('message',"Le format du récépisse n'est pas valide.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,   
                     'typedocuments'  => $typedocuments,                  
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRecepisse' => $request->get("inputrecepisse"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else if (count($controleRecepisee) > 0)
               {
                     $request->getSession()->getFlashBag()->add('messageDoublons',"Cet récepissé existe déjà.");
                     //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,    
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'typedocuments'  => $typedocuments,                  
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRecepisse' => $request->get("inputrecepisse"),

                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else 
               {
                  $niNineaproposition->setNinRecepisse($request->get('inputrecepisse'));
                  //$niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(1));

               }
            } 
            else if ($niNineaproposition->getNinFormejuridique()->getId() == 32 or $niNineaproposition->getNinFormejuridique()->getId() == 40  or $niNineaproposition->getNinFormejuridique()->getId() == 41  or $niNineaproposition->getNinFormejuridique()->getId() == 45 
               or $niNineaproposition->getNinFormejuridique()->getId() == 42  or  $niNineaproposition->getNinFormejuridique()->getId() == 43  or $niNineaproposition->getNinFormejuridique()->getId() == 46  or $niNineaproposition->getNinFormejuridique()->getId() == 47  or $niNineaproposition->getNinFormejuridique()->getId() == 56
                or $niNineaproposition->getNinFormejuridique()->getId() == 97  or $niNineaproposition->getNinFormejuridique()->getId() == 95) 
              {
               $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find($request->get('typedocuments')));
               $arrete= trim($request->get('inputarrete'));
               $controleArrete =  $this->getDoctrine()->getRepository(NiNineaproposition::class)->findBy(['ninArrete' => $arrete]);

               if($request->get('typedocuments') == 8)
               {
                 
                  if (preg_match($pattern, $arrete) == 1)
                  {
                     $request->getSession()->getFlashBag()->add('message',"Le format de l'arrêté n'est pas valide.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,   
                        'typedocuments'  => $typedocuments,                  
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninArrete' => $request->get("inputarrete"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else if (count($controleArrete) > 0)
                  {
                        $request->getSession()->getFlashBag()->add('messageDoublons',"Cet arrêté existe déjà.");
                        //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,    
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'typedocuments'  => $typedocuments,                  
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninArrete' => $request->get("inputarrete"),

                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else 
                  {
                     $niNineaproposition->setNinArrete($request->get('inputarrete'));
                     $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(8));

                  }
               }
               else if ($request->get('typedocuments') == 12)
               {
                  if (preg_match($pattern, $arrete) == 1)
                  {
                     $request->getSession()->getFlashBag()->add('message',"Le format de l'arrêté n'est pas valide.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,   
                        'typedocuments'  => $typedocuments,                  
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninArrete' => $request->get("inputarrete"),
                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else if (count($controleArrete) > 0)
                  {
                        $request->getSession()->getFlashBag()->add('messageDoublons',"Cet arrêté existe déjà.");
                        //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                        return $this->renderForm('ni_nineaproposition/new.html.twig', [
                        'ni_nineaproposition' => $niNineaproposition,
                        'form' => $form,
                        'formeunites' => $formeunites,             
                        'formejuridiques' => $formejuridiques,    
                        'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'typedocuments'  => $typedocuments,                  
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninArrete' => $request->get("inputarrete"),

                        'ni_nineaproposition_mere' => $ninineamere,
                        
                     ]);
                  }
                  else 
                  {
                     $niNineaproposition->setNinArrete($request->get('inputarrete'));
                     $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(8));

                  }
                  
               }else if($request->get('typedocuments') == 13)
               {
                  $niNineaproposition->setNinArrete($request->get('inputarrete'));
                  $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(13));

               }
              } 
            else
            {
               if (count($controleRccm) > 0)
               {
                  $request->getSession()->getFlashBag()->add('messageDoublons',"Ce registre de commerce existe déjà.");
                  //$formulaire += '<table id="tb_documents"> <tr><td style="width:40%"><label for="" class="TXT mt-2" id="labelregcom"> <b><u> Registre de commerce :</u>  <span style="color: red;">*</span> </b> </label></td> <td style="width:60%"> <input type="text" id="inputregcom" value="'.$request->get("registreCommerce").'" maxlength="19"	  minlength="15"   name="registreCommerce" required class="form-control form-control-sm mt-2 input-mask inputregcom" > <span style="color: red;" id="ninreg"></span></td></tr> </table>';

                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,    
                     'typedocuments'  => $typedocuments,                  
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),

                     'ni_nineaproposition_mere' => $ninineamere,
                  
                  ]);

               }
               
               elseif (preg_match($pattern_rccm, $rccmNormal) == 0) 
               {
                  
                     $request->getSession()->getFlashBag()->add('messageFormat',"Format invalide pour le registre de commerce.");
                     
                     return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,   
                     'typedocuments'  => $typedocuments,                                      
                     'ninFormeJuridique' => $ninFormejuridique,
                        'ninFormeunite' => $ninFormeunite,
                        'ninStatut' => $ninStatut,
                        'ninEnseigne' => $enseigne,
                        'ninRegcom' => $request->get("registreCommerce"),
                        'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);

               }

               elseif($annee > $annee_cours)
               {
                  
                  $request->getSession()->getFlashBag()->add('messageDate',"La date de création du registre ne doit pas être postérieure à l'année en cours.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                  'ni_nineaproposition' => $niNineaproposition,
                  'form' => $form,
                  'formeunites' => $formeunites,             
                  'formejuridiques' => $formejuridiques,     
                  'typedocuments'  => $typedocuments,                                    
                  'ninFormeJuridique' => $ninFormejuridique,
                  'ninFormeunite' => $ninFormeunite,
                  'ninStatut' => $ninStatut,
                  'ninEnseigne' => $enseigne,
                  'ninRegcom' => $request->get("registreCommerce"),
                  'ninDatereg' => $request->get("dateregcom"),
                  'ni_nineaproposition_mere' => $ninineamere,
                  
                  ]);
               }
               elseif($annee < "1900")
               {
                  
                  $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à l'année 1900.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                  'ni_nineaproposition' => $niNineaproposition,
                  'form' => $form,
                  'formeunites' => $formeunites,             
                  'formejuridiques' => $formejuridiques,    
                  'typedocuments'  => $typedocuments,                                     
                  'ninFormeJuridique' => $ninFormejuridique,
                  'ninFormeunite' => $ninFormeunite,
                  'ninStatut' => $ninStatut,
                  'ninEnseigne' => $enseigne,
                  'ninRegcom' => $request->get("registreCommerce"),
                  'ninDatereg' => $request->get("dateregcom"),
                  'ni_nineaproposition_mere' => $ninineamere,
                  
                  ]);
               }
               elseif ($datereg > $dateJour)
               {
                  $request->getSession()->getFlashBag()->add('messageDateJour',"La date du registre ne doit pas être postérieure à la date du jour.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,
                     'typedocuments'  => $typedocuments,                                         
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               elseif ($datereg_annee < $annee)
               {
                  //dd($datereg_annee);
                  $request->getSession()->getFlashBag()->add('messageDate',"La date du registre de commerce ne doit pas être antérieure à la date de création sur le registre.");
                  
                  return $this->renderForm('ni_nineaproposition/new.html.twig', [
                     'ni_nineaproposition' => $niNineaproposition,
                     'form' => $form,
                     'formeunites' => $formeunites,             
                     'formejuridiques' => $formejuridiques,  
                     'typedocuments'  => $typedocuments,                                       
                     'ninFormeJuridique' => $ninFormejuridique,
                     'ninFormeunite' => $ninFormeunite,
                     'ninStatut' => $ninStatut,
                     'ninEnseigne' => $enseigne,
                     'ninRegcom' => $request->get("registreCommerce"),
                     'ninDatereg' => $request->get("dateregcom"),
                     'ni_nineaproposition_mere' => $ninineamere,
                     
                  ]);
               }
               else
               {
                  $niNineaproposition->setNinRegcom( str_replace("_","",$request->get("registreCommerce")));
                  $niNineaproposition->setNinDatreg(new \Datetime($request->get("dateregcom")));
                  $niNineaproposition->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find(1));

               }
               
            }

           
            $entityManager->persist($niNineaproposition);
            $entityManager->persist($CompteurDemandeNINEA);
            $entityManager->flush();

              return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
          }

            //TODO traitement du jour ferie ici
            $datetoDay = new \DateTime('now'); // date reference 
            $jf=0;
            $tab=[];
            $msgFerier="";
            
            $toDayferie = new \DateTime();  // jour de ferie
            
            $jour_feries = $this->getDoctrine()->getRepository(NinJourFerier::class)->findAll();
            
            if(!$jour_feries){
              
              
            }else{
              
              foreach($jour_feries as $vars ){

                // recuperer le jour ferie dans la vars intermediare
                $toDayferie = $vars->getNinjour()->format('d-m-Y');
                // array_push($vars->getNinjour()->format('d-m-Y'), $tab);

                if($datetoDay->format('d-m-Y') == $toDayferie){
                  $toDayferie = $datetoDay->format('d-m-Y');
                  $msgFerier = $msgFerier.$vars->getNindescription();
                  $jf= 1;
                }
              }


            }


              return $this->renderForm('ni_nineaproposition/new.html.twig', [
              'ni_nineaproposition' => $niNineaproposition,
              'form' => $form,
              'formeunites' => $formeunites,             
              'formejuridiques' => $formejuridiques,                       
              'ninRegcom' => $ninRegcom,
              'ninDatreg' => $ninDatreg,
              'ni_nineaproposition_mere' => $ninineamere,
              'jour_ferie_txt' => $msgFerier,
              'jf' => $jf,

        ]);
    }


    
      /**
     * @Route("/controleNINEA/{id}", name="controleNINEA",  methods={"GET","POST"})
     */
    public function controleNINEA( $id = "")
    {
      //$controleNINEA =  $this->getDoctrine()->getRepository(NiPersonne::class)->findBy(['ninRaison' => $id]);
      $controleNINEA =  $this->getDoctrine()->getRepository(NINinea::class)->findBy(['ninNinea' => $id]);

      if (count($controleNINEA) > 0)
      {        
        return  new JsonResponse(1);
      } 
      else 
      {
          return new JsonResponse(0);
      }
    }


     /**
     * @Route("/listeNINEAs/{id}", name="listeNINEAs",  methods={"GET", "POST"})
     */
    public function listeNINEAs($id = "" , NINineaRepository $nINineaRepository)
    {
      $ninea = [];
        
      $ninea = $nINineaRepository->findNinea($id);

      $tab = [];
      foreach ($ninea as $key ) {
          $arr = [];
         // array_push($arr, $key->getNinNinea() );
          //array_push($arr,$key->getNinRegcom() );
        if ($key->getFormeJuridique()->getNiFormeunite()->getId() == 11 or $key->getFormeJuridique()->getNiFormeunite()->getId()  == 12)
          {
            array_push($arr, $key->getNinNinea() );
            //array_push($arr, $key->getNinNinea()." -[ ".$key->getNiPersonnes()[0]->getNinPrenom()." ".$key->getNiPersonnes()[0]->getNinNom()." ]" );

          }
          else
          {
            array_push($arr, $key->getNinNinea() );
            //array_push($arr, $key->getNinNinea()." -[ ".$key->getNiPersonnes()[0]->getNinRaison()." ]");
          }

          array_push($tab,$arr );

        }

        return  new JsonResponse($tab);

    }

     /**
     * @Route("/activated", name="activated", methods={"GET","POST"})
     */
    public function activated( )
    {
        $session=new Session();
        $session->set('actived',"");
        return new JsonResponse( "ok");
    }


      /**
     * @Route("/new/activite/{id}", name="ni_nineaproposition_new_activite", methods={"GET", "POST"})
     */
    public function newActivite(Request $request, EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition): Response
    {
      
        $form = $this->createForm(NiActivite2Type::class, $niNineaproposition);
        $form->handleRequest($request);

        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
       
        if ($form->isSubmitted() && $form->isValid()) {

          foreach ($request->get('to') as $key) {
            $ninproduit = new Ninproduits();
            $ninproduit->setRefproduits($entityManager->getRepository(RefProduits::class)->find($key));
            $niNineaproposition->addNinproduits($ninproduit);
            
            $entityManager->persist($ninproduit);
          }

          $session= new Session();
          $session->set('actived',4);
        
          $entityManager->flush();

           // $request->getSession()->getFlashBag()->add('message',"L'activité  a été ajoutée avec succés.");

            return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
          }
           
              return $this->renderForm('ni_nineaproposition/newActivite.html.twig', [
              
              'activite' => $form,
              'id' => $niNineaproposition->getId(),
              'statut' => $niNineaproposition->getStatut(),
              'act' => $niNineaproposition->getNinActivites(),
              'naemas' => $naemas,
              'produits' => $niNineaproposition->getNinproduits(),
              
        ]);
    }


    
     /**
     * @Route("/suppActiviteEtProduits/{id}", name="suppActiviteEtProduits", methods={"GET", "POST"})
     */
    public function suppActiviteEtProduits(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

      $session= new Session();
      $session->set('actived',3);

      $activite =  $entityManager->getRepository(NiActivite::class)->find($id);
      $niNineaproposition= $activite->getNiNineaproposition();
      $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nineaproposition"=>$niNineaproposition),array('id'=>'desc'));


      foreach ($ninproduits as $prod) {
        if($prod->getRefproduits()->getNaema()->getId()==$activite->getRefNaema()->getId()){
        //  var_dump($prod);
          $niNineaproposition->removeNinproduits($prod);
          $entityManager->remove($prod);
        }
     }
      
      $niNineaproposition->removeNinActivite($activite);
      $entityManager->remove($activite);
      $entityManager->flush();

       return $this->redirectToRoute('ni_nineaproposition_show', ["id"=>$niNineaproposition->getId()], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/activiteEtProduits/{id}", name="activiteEtProduits", methods={"GET", "POST"})
     */
    public function activiteEtProduits(Request $request, EntityManagerInterface $entityManager, NiNineaproposition $niNineaproposition): Response
    {

        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
       
        if ($request->get('ecohidden')) {
         
          $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("niNineaproposition"=>$niNineaproposition),array('id'=>'desc'));
          $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nineaproposition"=>$niNineaproposition),array('id'=>'desc'));
  
        
          $nbActivites=$request->get('nbActivites');
          $libActiviteglobale=$request->get('libelleactiviteglobale');
          $niNineaproposition->setNiLibelleactiviteglobale($libActiviteglobale);

          //dd($request->get('nbActivites'));
        
          for($indice = 1; $indice <= (int)($nbActivites); $indice++){
            //var_dump($ninproduits);

            $refProduit=$request->get('refProduit'.strval($indice));
            $refNaema=$request->get('refNaema'.strval($indice));
            $libelleActivite=$request->get('ninAutact'.strval($indice));

            
            $bActiviteTrouve=false;
           // var_dump($refProduit);
           foreach ($ninactivites as $act) {
            if($act->getRefNaema()->getId()==$refNaema){
                 $bActiviteTrouve=true;
                 $ninactivite=$act;
                // var_dump($ninactivite);
                 break;
            }
           }
            
            if($bActiviteTrouve==false){
              if($indice == 1 && count($niNineaproposition->getNinActivites())>0){
                $ninactivite = $entityManager->getRepository(NiActivite::class)->findBy(array("niNineaproposition"=>$niNineaproposition,"statActivprincipale"=>true))[0];
                
               // dd($ninactivite);

              $ninactivite->setNinAutact($libelleActivite);
              $ninactivite->setRefNaema($entityManager->getRepository(NAEMA::class)->find($refNaema));
            //  $niNineaproposition->addNinActivite($ninactivite);
            //  $entityManager->persist($ninactivite);

              }
              else{
                $ninactivite = new NiActivite();
                
             // var_dump($ninactivite);

              $ninactivite->setNiNineaproposition($niNineaproposition);
              if(count($niNineaproposition->getNinActivites())>0)
              $ninactivite->setStatActivPrincipale(false);
              else
              $ninactivite->setStatActivPrincipale(true);
              
            $ninactivite->setNinAutact($libelleActivite);
            $ninactivite->setRefNaema($entityManager->getRepository(NAEMA::class)->find($refNaema));
            $niNineaproposition->addNinActivite($ninactivite);
            $entityManager->persist($ninactivite);
              }

            }
            else {
             // $ninactivite=$act;
              $ninactivite->setNinAutact($libelleActivite);
              
             // var_dump($ninactivite);
            }

            foreach ($refProduit as $key) {
 
              $bProduitTrouve=false;
              foreach ($ninproduits as $prod) {
                if($prod->getRefproduits()->getId()==$key){
                     $bProduitTrouve=true;
                     $ninproduit = $prod;
                     //var_dump($ninactivite);
                     break;
                }
             }

              if($bProduitTrouve==false){
                $ninproduit = new Ninproduits();
                $ninproduit->setRefproduits($entityManager->getRepository(RefProduits::class)->find($key));
                $niNineaproposition->addNinproduits($ninproduit);
                
                $entityManager->persist($ninproduit);
              }
              else{
              //  var_dump($ninproduit);
              }
          
            }

            //Gestion de la suppression des produits
            foreach ($ninproduits as $ninprod) {
              if($ninprod->getRefproduits()->getNaema()->getId()==$refNaema){
                $bProduitASupprimer=true;
                foreach ($refProduit as $refprod) {
                  if($ninprod->getRefproduits()->getId()==$refprod){
                    $bProduitASupprimer=false;
                    break;
                  }
                }

                if($bProduitASupprimer==true){
                  $niNineaproposition->removeNinproduits($ninprod);
                  $entityManager->remove($ninprod);
                }
              }
             
            }

          }

          $session= new Session();
          $session->set('actived',4);
        
          $entityManager->flush();

           // $request->getSession()->getFlashBag()->add('message',"L'activité  a été ajoutée avec succés.");

            return $this->redirectToRoute('ni_nineaproposition_show', [
                "id"=>$niNineaproposition->getId()
              
              ], Response::HTTP_SEE_OTHER);
          }
           
              return $this->renderForm('ni_nineaproposition/newActivite.html.twig', [
              
              'activite' => $form,
              'id' => $niNineaproposition->getId(),
              'statut' => $niNineaproposition->getStatut(),
              'act' => $niNineaproposition->getNinActivites(),
              'naemas' => $naemas,
              'produits' => $niNineaproposition->getNinproduits(),
              
        ]);
    }
 
 
    
     /**
     * @Route("/{id}", name="ni_nineaproposition_deleteActivite", methods={"POST"})
     */
    public function deleteActivite(Request $request, NiActivite $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ni_nineaproposition_show', [], Response::HTTP_SEE_OTHER);
    }


 /**
     * @Route("/libererDemande/{id}", name="liberer_demande", methods={"GET", "POST"})
     */
    public function libererDemande(NiNineaproposition $niNineaproposition, Request $request,  EntityManagerInterface $entityManager,  DiversUtils $diversUtils, AuthorizationCheckerInterface $autorization): Response
    {
          
      $niNineaproposition->setNinlock(false);
      $niNineaproposition->setUpdatedBy($this->getUser());
      $entityManager->flush();

      return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);

    }

    
     /**
     * @Route("/{id}/{dirigeant}", name="ni_nineaproposition_show", methods={"GET", "POST"})
     */
    public function show(Request $request,  $id="",  EntityManagerInterface $entityManager,  DiversUtils $diversUtils, AuthorizationCheckerInterface $autorization, $dirigeant=""): Response
    {
      $max= new \DateTime("-10 years");

      $niNineaproposition = $entityManager->getRepository(NiNineaproposition::class)->find($id);
      $Odirigeant = $entityManager->getRepository(NiDirigeant::class)->find($dirigeant);

      $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
      $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();

     
        //si l'utilisateur connecté est agent validateur
      if($niNineaproposition->getStatut() == "c" ||  $niNineaproposition->getStatut() == "t")
      {
        if ($autorization->isGranted("ROLE_VALIDER_DEMANDE_NINEA" ) or $autorization->isGranted("ROLE_ADMIN" )) {
            
            $niNineaproposition->setNinlock(true);
            $niNineaproposition->setUpdatedBy($this->getUser());

            $entityManager->flush();

        }
      }
        $activite = new NiActivite();
        $form = $this->createForm(NiActiviteType::class, $activite);

        $activite_economique = new NiActiviteEconomique();
        $form2 = $this->createForm(NiActiviteEconomiqueType::class, $activite_economique);
        
        $form3 = $this->createForm(NiActivite2Type::class, $niNineaproposition);
        $form3->handleRequest($request);

        $form->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);
        
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
       
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $qvhs = $entityManager->getRepository(QVH::class)->findAll();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();

        $Dirigeants = $entityManager->getRepository(NiDirigeant::class)->findBy(array("ninNineaProposition"=>$niNineaproposition),array('id'=>'desc'));
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();

        $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("niNineaproposition"=>$niNineaproposition),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nineaproposition"=>$niNineaproposition));

        //registre de commerce
        $regcommerce = $niNineaproposition->getNinRegcom();

        //libelle de l' activité globale
        $activiteglobale = $niNineaproposition->getNiLibelleactiviteglobale();
       
        $niNinea_mere = [];
        if ($niNineaproposition->getNinStatut()->getId() == 2)
        {
            $nin_nineamere = $niNineaproposition->getNinNineamere();

            $niNinea_mere =  $entityManager->getRepository(NINinea::class)->findBy(['ninNinea' => $nin_nineamere]);

        }
        
        //string substr ( string $string , int $start [, int $length ] )
        //SNDKR2022A12344
      /*   $s1 = substr($regcommerce, 0, 2);
        $s2 = substr($regcommerce, 2, 3);
        $s3 = substr($regcommerce, 5, 4);
        $s4 = substr($regcommerce, 9, 1);
        $s5 = substr($regcommerce, -5);
        $chaines = [$s1,$s2,$s3,$s4,$s5];

        $registreCommerce = $s1." " . $s2. " " .$s3." ".$s4." ".$s5; */
        
       // $registreCommerce = implode(" ", $chaines);   
             
        return $this->render('ni_nineaproposition/show.html.twig', [
				'form' => $form->createView(),
				'form2' => $form2->createView(),
				'form3' => $form3->createView(),
				'ni_nineaproposition' => $niNineaproposition,
				'registreCommerce' => $regcommerce,
				'formeunites' => $formeunites,
				'formejuridiques' => $formejuridiques,
				'regions' => $regions,
				'sexes' => $sexe,
				'nationalites' => $nationalites,
				'civilites' => $civilites,
				'typevoies' => $typevoies,
				'departements' => $departements,
				'cacrs' => $cacrs,
				'cavs' => $cavs,
				'qvhs' => $qvhs,
				'produits' => $produits,
				'Odirigeant' => $Odirigeant,
				'qualifications' => $qualifications,
				'Dirigeants' => $Dirigeants,
				'max' => $max,
				'statut' => $niNineaproposition->getStatut(),
				'naemas' => $naemas,
				'ninactivites' => $ninactivites,
				'ninproduits' => $ninproduits,
            'activiteglobale' => $activiteglobale,
            'niNinea_mere' => $niNinea_mere != null ? $niNinea_mere[0] : "",
        ]);
    }



    /**
     * @Route("/{id}/edit", name="ni_nineaproposition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiNineaproposition $niNineaproposition, EntityManagerInterface $entityManager,  DiversUtils $diversUtils): Response
    {
        $form = $this->createForm(NiNineapropositionType::class, $niNineaproposition);

        $lastpersonne = $entityManager->getRepository(NiPersonne::class)->findBy(array("nineaproposition"=>$niNineaproposition),array('created_at'=>'desc'),1,0);

        $nom = $lastpersonne[0]->getNinNom() ;
        $prenom =  $lastpersonne[0]->getNinPrenom()   ;
        //$adresse =   $lastpersonne[0]->getAdresse()  ;

        if ( $lastpersonne[0]->getCivilite()) {
           $civilite =  $lastpersonne[0]->getCivilite()->getId() ;
        }else
            $civilite ="" ;

         if ( $lastpersonne[0]->getNinDateNaissance())
           $datenais =   $lastpersonne[0]->getNinDateNaissance()->format("Y-m-d");
         else
            $datenais = "";

         if ( $lastpersonne[0]->getNationalite())
            $nationalite =  $lastpersonne[0]->getNationalite()->getId();
          else
            $nationalite = "";

          if ( $lastpersonne[0]->getNinSexe())
            $nsexe =  $lastpersonne[0]->getNinSexe()->getId()    ;
          else
           $nsexe = "";

          if ( $niNineaproposition->getNinFormejuridique()->getNiFormeunite())
              $formeunite = $niNineaproposition->getNinFormejuridique()->getNiFormeunite()->getId();
          else
            $formeunite = "";

          if ( $lastpersonne[0]->getNinDateCNI())
              $datecni =  $lastpersonne[0]->getNinDateCNI()->format("Y-m-d");
          else
              $datecni = "";
              $datepassport = "";

          //QVH POUR PERSONNE
          if ( $lastpersonne[0]->getNinQvh()) {
            $qvh_personne = $lastpersonne[0]->getNinQvh();
          }else
              $qvh_personne ="" ;

          if ( $lastpersonne[0]->getNinQvh()) {
            $cacr_personne = $lastpersonne[0]->getNinQvh()->getQvhCACRID()->getId();
          }else
            $cacr_personne ="" ;

          if ( $lastpersonne[0]->getNinQvh()) {
            $cav_personne = $lastpersonne[0]->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getId();
          }else
              $cav_personne ="" ;

          if ( $lastpersonne[0]->getNinQvh()) {
              $departement_personne = $lastpersonne[0]->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getId();
          }else
              $departement_personne ="" ;

          if ( $lastpersonne[0]->getNinQvh()) {
             $region_personne = $lastpersonne[0]->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getId();
          }else
              $region_personne ="" ;


        $departements = $entityManager->getRepository(Departement::class)->findBy(array("depRegCD"=>$region_personne));
        $cavs = $entityManager->getRepository(CAV::class)->findBy(array("cavDEPID"=>$departement_personne));
        $cacrs = $entityManager->getRepository(CACR::class)->findBy(array("cacrCAVID"=>$cav_personne));
        $qvhs = $entityManager->getRepository(QVH::class)->findBy(array("qvhCACRID"=>$cacr_personne));

        $lieunais =   $lastpersonne[0]->getNinLieuNaissance();
        $cni =  $lastpersonne[0]->getNinCNI() ;
        $passport =  $lastpersonne[0]->getNinCNI();
        $raison =  $lastpersonne[0]->getNinRaison();
        $sigle =  $lastpersonne[0]->getNinSigle();
        $formejuridique = $niNineaproposition->getNinFormejuridique();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();

        $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
        $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();

        $regions = $entityManager->getRepository(Region::class)->findAll();

        $lastcoordoonnee=$entityManager->getRepository(NiCoordonnees::class)->findBy(array("niNineaproposition"=>$niNineaproposition),array('id'=>'desc'),1,0);

        if ( $lastcoordoonnee[0]->getNinTypevoie()) {
          $typevoie = $lastcoordoonnee[0]->getNinTypevoie()->getId();
        }else
            $typevoie ="" ;

          $voie = $lastcoordoonnee[0]->getNinVoie();
          $numvoie = $lastcoordoonnee[0]->getNinnumVoie();
          $adresse1 = $lastcoordoonnee[0]->getNinadresse1();
          $adresse2 = $lastcoordoonnee[0]->getNinadresse2();
          $telephone1 = $lastcoordoonnee[0]->getNinTelephon1();
          $telephone2 = $lastcoordoonnee[0]->getNintelephon2();
          $email = $lastcoordoonnee[0]->getNinEmail();
          $boitepostale = $lastcoordoonnee[0]->getNinBP();

          if ( $lastcoordoonnee[0]->getQvh()) {
            $qvh = $lastcoordoonnee[0]->getQvh();
          }else
              $qvh ="" ;

          if ( $lastcoordoonnee[0]->getQvh()->getQvhCACRID()) {
            $cacr = $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getId();
          }else
            $cacr ="" ;

          if ( $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getCacrCAVID()) {
            $cav = $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getCacrCAVID()->getId();
          }else
              $cav ="" ;

          if ( $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()) {
              $departement = $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getId();
          }else
              $departement ="" ;

          if ( $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()) {
             $region = $lastcoordoonnee[0]->getQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getId();
          }else
              $region ="" ;

           $departements = $entityManager->getRepository(Departement::class)->findBy(array("depRegCD"=>$region));
           $cavs = $entityManager->getRepository(CAV::class)->findBy(array("cavDEPID"=>$departement));
           $cacrs = $entityManager->getRepository(CACR::class)->findBy(array("cacrCAVID"=>$cav));
           $qvhs = $entityManager->getRepository(QVH::class)->findBy(array("qvhCACRID"=>$cacr));

          // $lastactivite = $entityManager->getRepository(NiActivite::class)->findBy(array("niNineaproposition"=>$niNineaproposition),array('created_at'=>'desc'),1,0);
          // $statutActivite = $lastactivite[0]->getStatutActivite();

          //coordonnees
          $lastacteconom=$entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nineaproposition"=>$niNineaproposition),array('id'=>'desc'),1,0);

        if ( $lastacteconom){

          $chiffre_affaire =  $lastacteconom[0]->getNinAffaire();
          $annnee_ca = $lastacteconom[0]->getNinAnneeCa();
          $capital = $lastacteconom[0]->getNinCapital();
          $effectif = $lastacteconom[0]->getNinEffectif();
          $effectif1 = $lastacteconom[0]->getNinEffect1();
          $effectifem = $lastacteconom[0]->getNinEffectifFem();
          $effectifemsais = $lastacteconom[0]->getNinEffectifFemSAIS();
          $ninRegcom = $niNineaproposition->getNinRegcom();
          $ninDatreg = $niNineaproposition->getNinDatreg()->format("Y-m-d");
          $ninNineamere = $niNineaproposition->getNinNineamere();
          $ninSiglemere = $niNineaproposition->getNinSiglemere();

        }
        else{
          $chiffre_affaire =  "";
          $annnee_ca = "";
          $capital ="";
          $effectif = "";
          $effectif1 = "";
          $effectifem = "";
          $effectifemsais = "";
          $ninRegcom = "";
          $ninDatreg = "";
          $ninNineamere ="";
          $ninSiglemere ="";
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $CompteurNINEA = new CompteurNINEA();

          $numNINEA=$diversUtils->genereNumNINEA($entityManager);
          $niNineaproposition->setNinNinea($numNINEA);

          $formeunite =  $request->get("formeunite");;

          $personne = $niNineaproposition->getNiPersonne();
          if ($formeunite==1)
          {

              //récupération personne physique
              $nom = $request->get("nom");
              $prenom = $request->get("prenom");
              $adresse = $request->get("adresse");
              $civilite = $request->get("civilite");
              $datenais = $request->get("datenais");
              $lieunais = $request->get("lieunais");
              $nationalite = $request->get("nationalite");
              $nsexe = $request->get("sexe");

              $personne->setNinNom($nom);
              $personne->setNinPrenom($prenom);
              $personne->setAdresse($adresse);
              $personne->setCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
              $personne->setNinDateNaissance(new \DateTime($datenais));
              $personne->setNinLieuNaissance($lieunais);
              $personne->setNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
              $personne->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));

              if( $nationalite=="07"){
                  $cni = $request->get("cni");
                  $datecni = $request->get("dateCni");
                  $personne->setNinCNI($cni);
                  $personne->setNinDateCNI(new \DateTime($datecni));
              }
              else {
                  $passport = $request->get("passport");
                  $datepassport = $request->get("datepassport");
                  $personne->setNinCNI($passport);
                  $personne->setNinDateCNI(new \DateTime($datepassport));
              }

           $personne->setNinRaison("");
           $personne->setNinSigle("");

          }else{
              //recupération personne morale
           $raison = $request->get("raison");
           $sigle = $request->get("sigle");
           $personne->setNinRaison($raison);
           $personne->setNinSigle($sigle);

          }

           $formejuridique = $entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique"));
           $formeunite = $entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique"))->getNiFormeunite()->getId();

           $niNineaproposition->setNinFormejuridique($entityManager->getRepository(NiFormejuridique::class)->find($request->get("formejuridique")));
           $niNineaproposition->setUpdatedBy($this->getUser());

          // $personne->setUpdatedBy($this->getUser());

           if($request->get("radio")==1)
           {

             $niNineaproposition->setNinRemarque($request->get("txtMotif"));
             $niNineaproposition->setStatut("r");
             $entityManager->flush();
             $request->getSession()->getFlashBag()->add('message',"Demande rejetée.");

             return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);

           }else{

              //validation
             $niNineaproposition->setStatut("v");
             $ninea = new NINinea();

             $ninea->setFormeJuridique($niNineaproposition->getNinFormejuridique());
             $ninea->setNinStatut($niNineaproposition->getStatut());
             $ninea->setNinEnseigne($niNineaproposition->getNinEnseigne());
             $ninea->setNinRegcom($niNineaproposition->getNinRegcom());
             if ($formeunite == 1)
             {
              $ninea->setNiPersonne($niNineaproposition->getNiPersonne());
             } else
             {
              $ninea->setNiPersonne($niNineaproposition->getNiPersonne());
             }

             $ninea->setCreatedBy($this->getUser());
             $ninea->setModifiedBy($this->getUser());

             $numNinea=$diversUtils->genereNumNINEA($entityManager);
             $ninea->setNinNinea($numNinea);

             $entityManager->persist($CompteurNINEA);
             $entityManager->persist($ninea);

             $entityManager->flush();

             $request->getSession()->getFlashBag()->add('message',"NINEA validé avec succes.");

             return $this->redirectToRoute('n_i_ninea_index', [], Response::HTTP_SEE_OTHER);

           }

            $entityManager->flush();

            return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_nineaproposition/edit.html.twig', [
            'ni_nineaproposition' => $niNineaproposition,
            'form' => $form,
            'formeunites' => $formeunites,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'formejuridiques' => $formejuridiques,
            'nom' => $nom,
            'prenom' => $prenom,
            'civilite' => $civilite,
            'datenais' => $datenais,
            'lieunais' => $lieunais,
            'nationalite' => $nationalite,
            'nsexe' => $nsexe,
            'cni' => $cni,
            'dateCni' => $datecni,
            'passport' => $passport,
            'datepassport' => $datepassport,
            'raison' => $raison,
            'sigle' => $sigle,
            'formeunite' => $formeunite,
            'formejuridique' => $formejuridique,

            'region_personne' => $region_personne,
            'departement_personne' => $departement_personne,
            'cav_personne' => $cav_personne,
            'cacr_personne' => $cacr_personne,
            'qvh_personne' => $qvh_personne,

            'regions' => $regions,
            'region' => $region,
            'typevoies' => $typevoies,
            'typevoie' => $typevoie,
            'voie' => $voie,
            'numvoie' => $numvoie,
            'qvhs' => $qvhs,
            'qvh' => $qvh,
            "adresse1" => $adresse1,
            "adresse2" => $adresse2,
            "telephone1" => $telephone1,
            "telephone2" => $telephone2,
            "email" => $email,
            "departements" => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'cacr' => $cacr,
            'cav' => $cav,
            'departement' => $departement,
            'boitepostale' => $boitepostale,


            //Activité économique
            'ninAffaire' => $chiffre_affaire,
            'ninAnneeCa' => $annnee_ca,
            'ninCapital' => $capital,
            'ninEffectif' => $effectif,
            'nin_Effect1' => $effectif1,
            'ninEffectifFem' => $effectifem,
            'ninEffectifFemSAIS' => $effectifemsais,
            'ninRegcom' => $ninRegcom,
            'ninDatreg' => $ninDatreg,
            'ninNineamere' => $ninNineamere,
            'ninSiglemere' => $ninSiglemere,
        ]);
    }

     /**
     * @Route("deleteBrouillon/{id}", name="deleteBrouillon", methods={"POST","GET"})
     */
    public function deleteBrouillon(Request $request, NiNineaproposition $niNineaproposition, EntityManagerInterface $entityManager): Response
    {
      //var_dump($niNineaproposition);
       // if ($this->isCsrfTokenValid('delete'.$niNineaproposition->getId(), $request->request->get('_token'))) {
        $personne = $niNineaproposition->getNiPersonne();
        $coordonnee = $niNineaproposition->getCoordonnees()[0];
        $activite_economique = $niNineaproposition->getNiActiviteEconomiques()[0];

        if($personne){
          $entityManager->remove($personne);
        }
        if($coordonnee){
          $entityManager->remove($coordonnee);
        }
        if($activite_economique){
          $entityManager->remove($activite_economique);
        }

        foreach ($niNineaproposition->getNinActivites() as $key) {
          $entityManager->remove($key);
        }
        foreach ($niNineaproposition->getNinDirigeants() as $key) {
          $entityManager->remove($key);
        }
        foreach ($niNineaproposition->getNinproduits() as $key) {
          $entityManager->remove($key);
        }

        $entityManager->remove($niNineaproposition);
        $entityManager->flush();

      //  }

        return $this->redirectToRoute('listeBrouillons', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="ni_nineaproposition_delete", methods={"POST"})
     */
    public function delete(Request $request, NiNineaproposition $niNineaproposition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niNineaproposition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niNineaproposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ni_nineaproposition_index', [], Response::HTTP_SEE_OTHER);
    }
}
<?php

namespace App\Controller;

use App\Entity\TempNINinea;
use App\Entity\NINinea;
use App\Entity\QVH;
use App\Entity\TempNiPersonne;
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
use App\Entity\TempNiCoordonnees;
use App\Entity\TempNiActiviteEconomique;
use App\Entity\CategorySyscoa;
use Doctrine\ORM\EntityManager;
use App\Entity\NiFormejuridique;
use App\Entity\NiNineaproposition;
use App\Entity\CompteurDemandeNINEA;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiDirigeant;
use App\Entity\NinJourFerier;
use App\Entity\Ninproduits;
use App\Entity\NiStatut;
use App\Entity\Qualite;
use App\Entity\RefProduits;
use App\Entity\CAV;
use App\Entity\CACR;
use App\Entity\Citi;
use App\Entity\Pays;
use App\Entity\NAEMA;
use App\Entity\NAEMAS;
use App\Entity\NiSexe;
use App\Entity\Region;
use App\Entity\SYSCOA;


use App\Entity\NiNationalite;
use App\Entity\NiTypepersone;
use App\Services\DiversUtils;
use App\Entity\CategoryNaemas;


use App\Form\TempNINineaType;
use App\Repository\TempNiNineaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/temp/n/i/ninea")
 */
class TempNINineaController extends AbstractController
{
    /**
     * @Route("/", name="app_temp_n_i_ninea_index", methods={"GET"})
     */
    public function index(TempNiNineaRepository $tempNiNineaRepository): Response
    {
        return $this->render('temp_ni_ninea/index.html.twig', [
            'temp_n_i_nineas' => $tempNiNineaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_temp_n_i_ninea_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TempNiNineaRepository $tempNiNineaRepository,NINinea $ninea, EntityManagerInterface $entityManager): Response
    {
        $tempNINinea = new TempNINinea();
        $form = $this->createForm(TempNINineaType::class, $tempNINinea);
        $form->handleRequest($request);

        if ($request->get('sauvegarder')) {
            //Entete
            $ninEnseigne = $request->get("ninEnseigne");
            $ninRegcom = $request->get("ni_nineaproposition_ninRegcom");
            $idninDatreg = $request->get("idninDatreg");
            $tempNINinea->setNinEnseigne($ninEnseigne);
            $tempNINinea->setNinRegcom($ninRegcom);
            $tempNINinea->setFormeJuridique($ninea->getFormejuridique());
          //  $tempNINinea->setNinStatut($ninea->getNinStatut());
            $tempNINinea->setStatut('c');
            $tempNINinea->setNinNinea($ninea->getNinNinea());
            $tempNINinea->setCreatedBy($this->getUser());
            $tempNINinea->setModifiedBy($this->getUser());
            
            
            

            if($idninDatreg)
                $tempNINinea->setNinDateCNI(new \DateTime($idninDatreg));
            
            //Info activité economique

            $tempNiActiviteEconomique = new TempNiActiviteEconomique();

          
            $ninAffaire_modif=$request->get('ninAffaire_modif');
            $ninCapital_modif=$request->get('ninCapital_modif');
            $ninEffectif_modif=$request->get('ninEffectif_modif');
            $ninEffectifFem_modif=$request->get('ninEffectifFem_modif');
            $ninAnneeCa_modif=$request->get('ninAnneeCa_modif');
            $ninEffect1_modif=$request->get('ninEffect1_modif');
            $ninEffectifFemSAIS_modif=$request->get('ninEffectifFemSAIS_modif');
            $tempNiActiviteEconomique->setNinAnneeCa($ninAnneeCa_modif);
            if($ninCapital_modif)
                $tempNiActiviteEconomique->setNinCapital($ninCapital_modif);
            if($ninEffect1_modif)
              $tempNiActiviteEconomique->setNinEffect1($ninEffect1_modif);
            if($ninEffectifFem_modif)
                $tempNiActiviteEconomique->setNinEffectifFem($ninEffectifFem_modif);
            if($ninEffectif_modif)
                $tempNiActiviteEconomique->setNinEffectif($ninEffectif_modif);
            if($ninAffaire_modif)
                $tempNiActiviteEconomique->setNinAffaire($ninAffaire_modif);
            if($ninEffectifFemSAIS_modif)
               $tempNiActiviteEconomique->setNinEffectifFemSAIS($ninEffectifFemSAIS_modif);

           
            


            //Info coordonnées 

            $coordonnee = new TempNiCoordonnees();
            if ($request->get("typevoie_coordonnees_modif"))
            {
              $typevoie = $request->get("typevoie_coordonnees_modif");
              $coordonnee->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
            }
            $qvh =  $request->get("qvh_coordonnees_modif");
            $numvoie = $request->get("numvoie_coordonnees_modif");
            $voie = $request->get("voie_coordonnees_modif");
            $adresse1 = $request->get("adresse1_coordonnees_modif");
            $telephone1 = $request->get("telephone1_coordonnees_modif");
            $telephone2 = $request->get("telephone2_coordonnees_modif");
            $email = $request->get("email_coordonnees_modif");
            $boitepostale =  $request->get("bp_coordonnees_modif");   
            $url =  $request->get("url_coordonnees_modif");   
            $coordonnee->setNinVoie($voie);
            $coordonnee->setNinnumVoie($numvoie);
            $coordonnee->setNinadresse1($adresse1);
            $coordonnee->setNintelephon2($telephone2);
            $coordonnee->setNinTelephon1($telephone1);
            $coordonnee->setNinEmail($email);
            $coordonnee->setQvh($entityManager->getRepository(QVH::class)->find($qvh));
            $coordonnee->setNinBP($boitepostale);
            $coordonnee->setNinUrl($url);
           

          
  
  

            
            if ($ninea->getFormejuridique()->getNiFormeunite()->getId() == 11  or $ninea->getFormejuridique()->getNiFormeunite()->getId() == 12 ){
                //Infos personne physique
                $personne = new TempNiPersonne();
                $civilite=$request->get('civilite_modif');
                $prenom=$request->get('prenom_modif');
                $nom=$request->get('nom_modif');
                $sexe=$request->get('sexe_modif');
                $datenais = $request->get("datenais_modif");
                $lieunais = $request->get("lieunais_modif");
                $nationalite = $request->get("nationalite_modif");
                $telephone = $request->get('telephone_modif');
                if( $nationalite=="SN"){
                    $cni = $request->get("cni_modif");
                    $datecni = $request->get("datecni_modif");
                    $personne->setNinCNI($cni);
                    if($datecni)
                        $personne->setNinDateCNI(new \DateTime($datecni));
                    }
                else {
                    $passport = $request->get("passport_modif");
                    $datepassport = $request->get("datepassport_modif");
                    $personne->setNinCNI($passport);
                    if($datepassport)
                          $personne->setNinDateCNI(new \DateTime($datepassport));
                    
                }
                if ($request->get("qvh_modif"))
                {
                   $qvh_personne =  $request->get("qvh_modif");
                   $personne->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh_personne));
                } 
                $email = $request->get('email_modif');
                if ($request->get("typevoie_modif"))
                {
                    $typevoie = $request->get("typevoie_modif");
                }
                $voie = $request->get('voie_modif');
                $numvoie = $request->get('numvoie_modif'); 
                $adresse = $request->get('adresse_modif'); 


                

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
                $personne->setNinSexe($entityManager->getRepository(NiSexe::class)->find($sexe));
                if ($request->get("typevoie"))
                {
                  $typevoie = $request->get("typevoie");
                  $personne->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
                }


                

               
          
                

            }else{

            }

            $tempNiActiviteEconomique->setNiNinea($tempNINinea);
            $coordonnee->setNinNinea($tempNINinea);
            $personne->setNinNinea($tempNINinea);

            
            $entityManager->persist($tempNiActiviteEconomique);
            $entityManager->persist($coordonnee);
            $entityManager->persist($personne);
            $entityManager->persist($tempNINinea);
            $entityManager->flush();

            return $this->redirectToRoute('app_temp_n_i_ninea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('temp_ni_ninea/new.html.twig', [
            'temp_n_i_ninea' => $tempNINinea,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_temp_n_i_ninea_show", methods={"GET"})
     */
    public function show(TempNINinea $tempNINinea): Response
    {
        return $this->render('temp_ni_ninea/show.html.twig', [
            'temp_n_i_ninea' => $tempNINinea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_temp_n_i_ninea_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TempNINinea $tempNINinea, TempNiNineaRepository $tempNiNineaRepository,EntityManagerInterface $entityManager): Response
    {
        $nINinea = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea"=>$tempNINinea->getNinNinea()]);
        $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
        $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();
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
        $coordoonnes = $entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$nINinea),array('id'=>'desc'));
        $lastacteEcononomique=$entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'),1,0);
        if(count($lastacteEcononomique)>0)
          $lastactiviteEco =$lastacteEcononomique[0];
        else
          $lastactiviteEco=null;
        
        $activiteseconmiques = $entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'));
        

        if(count($coordoonnes)>0)
         $coordoonne =$coordoonnes[0];
        else
         $coordoonne=null;
        
        $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("nINinea"=>$nINinea),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nINinea"=>$nINinea));
        $activiteglobale = $nINinea->getNiLibelleactiviteglobale();
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();

        


        return $this->renderForm('temp_ni_ninea/edit.html.twig', [
            'tempninea' => $tempNINinea,
            'ninea' => $nINinea,
            'formeunites' => $formeunites,             
            'formejuridiques' => $formejuridiques, 
            'registreCommerce'=>"",
            'regions' => $regions,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'typevoies' => $typevoies,
            'departements' => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'qvhs' => $qvhs,
            'lastcoordoonnee'=>$coordoonne,
            'lastactiviteEco'=>$lastactiviteEco,
            'activiteseconmiques' => $activiteseconmiques,
            'activiteglobale' => $activiteglobale,
            'naemas' => $naemas,
				    'ninactivites' => $ninactivites,
				    'ninproduits' => $ninproduits,
            'produits' => $produits,
            'statut' => "c",
        ]);
    }

    /**
     * @Route("/{id}", name="app_temp_n_i_ninea_delete", methods={"POST"})
     */
    public function delete(Request $request, TempNINinea $tempNINinea, TempNiNineaRepository $tempNiNineaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tempNINinea->getId(), $request->request->get('_token'))) {
            $tempNiNineaRepository->remove($tempNINinea, true);
        }

        return $this->redirectToRoute('app_temp_n_i_ninea_index', [], Response::HTTP_SEE_OTHER);
    }
}

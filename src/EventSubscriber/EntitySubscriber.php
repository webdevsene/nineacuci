<?php

namespace App\EventSubscriber;

use App\Entity\AchatProduction;
use App\Entity\AchatProductionUtil;
use App\Entity\Actionnaire;
use App\Entity\Activities;
use App\Entity\Bilan;
use App\Entity\BilanSmt;
use App\Entity\CommissairesComptes;
use App\Entity\CompteDeResultats;
use App\Entity\ComptederesultatSmt;
use App\Entity\CuciImmoPlus;
use App\Entity\CuciMigLog;
use App\Entity\DbChange;
use App\Entity\DettesCreancesSmt;
use App\Entity\DettesCreancesSmtUtil;
use App\Entity\Dirigeant;
use App\Entity\Effectifs;
use App\Entity\EtatDesStocksSmt;
use App\Entity\EtatDesStocksSmtUtil;
use App\Entity\Filiales;
use App\Entity\FluxDesTresoreries;
use App\Entity\FormeJuridique;
use App\Entity\ImmoBrut;
use App\Entity\JournalCreancesImpayeesSmt;
use App\Entity\JournalCreancesImpayeesSmtUtil;
use App\Entity\JournalDettesPayerSmtUtil;
use App\Entity\JournalTresorerie;
use App\Entity\JournalTresorerieSmtUtil;
use App\Entity\MembreConseil;
use App\Entity\NiActivite;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiAdministration;
use App\Entity\NiCoordonnees;
use App\Entity\NiDirigeant;
use App\Entity\NINinea;
use App\Entity\NiNineaproposition;
use App\Entity\Ninproduits;
use App\Entity\NiPersonne;
use App\Entity\ProductionDeExercice;
use App\Entity\ProductionDeExerciceUtil;
use App\Entity\Qualite;
use App\Entity\RefAgg;
use App\Entity\RefAggSmt;
use App\Entity\Repertoire;
use App\Entity\SequenceNumeroCUCI;
use App\Entity\SuiviMaterielMobilier;
use App\Entity\SuiviMaterielMobilierUtilSmt;
use App\Entity\SystemeComptabilite;
use App\Entity\User;
use App\Services\LogChangesService;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\ManagerRegistry;

class EntitySubscriber implements EventSubscriber
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var LogChangesService
     */
    private $logChangesService;

    /**
     * @var array
     */
    private $insertedEntities = [];

    /**
     * EntitySubscriber constructor.
     * @param LogChangesService $logChangesService
     */
    public function __construct(
        LogChangesService $logChangesService
    )
    {
        $this->logChangesService = $logChangesService;
    }

    /**
     * @param OnFlushEventArgs $args
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        $updatedEntities = $unitOfWork->getScheduledEntityUpdates();
        $deletedEntities = $unitOfWork->getScheduledEntityDeletions();
        $this->insertedEntities = $unitOfWork->getScheduledEntityInsertions();

        foreach ($updatedEntities as $updatedEntity) {
            // skip for DbChange entity... ignorer les entity util 
            if ($updatedEntity instanceof DbChange) {
                continue;
            }
            if ($updatedEntity instanceof ProductionDeExerciceUtil) {
                continue;
            }
            if ($updatedEntity instanceof AchatProductionUtil) {
                continue;
            }
            if ($updatedEntity instanceof AchatProduction) {
                continue;
            }
            if ($updatedEntity instanceof SuiviMaterielMobilierUtilSmt) {
                continue;
            }
            if ($updatedEntity instanceof JournalTresorerieSmtUtil) {
                continue;
            }
            if ($updatedEntity instanceof JournalDettesPayerSmtUtil) {
                continue;
            }
            if ($updatedEntity instanceof JournalCreancesImpayeesSmtUtil) {
                continue;
            }
            if ($updatedEntity instanceof EtatDesStocksSmtUtil) {
                continue;
            }
            if ($updatedEntity instanceof DettesCreancesSmtUtil) {
                continue;
            }

            // skeep entities as associated to Repertoire
            if ($updatedEntity instanceof SequenceNumeroCUCI) {
                continue;
            }
            /*if ($updatedEntity instanceof Repertoire) {
                continue;
            }*/
            // skeep entities as associated to NINEA
            if ($updatedEntity instanceof NINinea) {
                continue;
            }
            if ($updatedEntity instanceof NiNineaproposition) {
                continue;
            }
            if ($updatedEntity instanceof NiActivite) {
                continue;
            }
            if ($updatedEntity instanceof Ninproduits) {
                continue;
            }
            if ($updatedEntity instanceof NiDirigeant) {
                continue;
            }
            if ($updatedEntity instanceof NiActiviteEconomique) {
                continue;
            }
            if ($updatedEntity instanceof NiCoordonnees) {
                continue;
            }
            if ($updatedEntity instanceof NiPersonne) {
                continue;
            }
            if ($updatedEntity instanceof User) {
                continue;
            }
            // ignore entities Ref_Agg
            if ($updatedEntity instanceof RefAgg) {
                continue;
            }
            // ignore entities Ref_Agg
            if ($updatedEntity instanceof RefAggSmt) {
                continue;
            }
            if ($updatedEntity instanceof Qualite) {
                continue;
            }
            if ($updatedEntity instanceof Activities) {
                continue;
            }
            if ($updatedEntity instanceof CommissairesComptes) {
                continue;
            }
            if ($updatedEntity instanceof SystemeComptabilite) {
                continue;
            }
            if ($updatedEntity instanceof FormeJuridique) {
                continue;
            }
            

            
            $changeSet = $unitOfWork->getEntityChangeSet($updatedEntity);
            
            // get metadata
            $entityClassName = get_class($updatedEntity);
            $metaData = $entityManager->getClassMetadata($entityClassName);

            // get entity id
            $entityId = $this->getEntityId($unitOfWork, $updatedEntity);
            
            // customization pour obtenir createdAt, repertoire, createdBy

            $codeCuci = "";
            $created_at = new DateTime("");
            $owner = "";
            $cr= "";            

            if($updatedEntity instanceof CompteDeResultats){
                
                // TODO somethink here to find codeCuci
                $key = $entityManager->getRepository(CompteDeResultats::class)->findOneBy(['id' => $entityId]);
                
                $codeCuci = $key->getCuciRepCode()!=null ? $key->getCuciRepCode()->getCodeCuci()."/".$key->getAnneeFinanciere():"";
                
                $created_at = $key->getCreatedAt() ?? new \DateTime();                
                
                $owner = $key->getCreatedBy()!=null ? $key->getCreatedBy()->getUsername():""; 
                # $owner = $updatedEntity->getCreatedBy()->getUserIdentifier();
            }
            if($updatedEntity instanceof FluxDesTresoreries){
                
                // TODO somethink here to find codeCuci
                $key = $entityManager->getRepository(FluxDesTresoreries::class)->findOneBy(['id' => $entityId]);
                
                $codeCuci = $key->getCuciRepCode()!=null ? $key->getCuciRepCode()->getCodeCuci()."/".$key->getAnneeFinanciere():"";
                
                # $created_at = $updatedEntity->getCreatedAt();                
                $created_at = $key->getCreatedAt() ?? new \DateTime();                
                
                $owner = $key->getModifiedBy()!=null ? $key->getModifiedBy()->getUsername():""; 
                # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
            }
            if($updatedEntity instanceof Bilan){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Bilan::class)->findOneBy(['id' => $entityId]);

                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere():"";

                    # $owner = $cr->getModifiedBy()->getUserIdentifier(); 
                    $owner = $cr->getModifiedBy()!=null ? $cr->getModifiedBy()->getUsername():"";   
                    
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at =  $cr->getCreatedAt() ?? new \DateTime();                

                }                
            }
            if($updatedEntity instanceof ImmoBrut){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ImmoBrut::class)->findOneBy(['id' => $entityId]);



                if($cr){

                   # $codeCuci = $updatedEntity->getRepertoire()->getCodeCuci();
                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere():"";

                    # $owner = $cr->getModifiedBy()->getUserIdentifier(); 
                    # $owner = $updatedEntity->getModifiedby()->getUserIdentifier(); 
                    $owner = $cr->getModifiedby()!=null ? $cr->getModifiedby()->getUsername():"";   
                    
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at = $cr->getCreatedAt() ?? new \DateTime();                

                }                
            }
            if($updatedEntity instanceof CuciImmoPlus){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(CuciImmoPlus::class)->findOneBy(['id' => $entityId]);

                if($cr){
                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere():"";
                    $owner = $cr->getModifiedBy()!=null ? $cr->getModifiedBy()->getUsername():"";                     
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at = $cr->getCreatedAt() ?? new \DateTime();                

                }                
            }
            if($updatedEntity instanceof Effectifs){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Effectifs::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere() : "";
                    
                    $owner = $cr->getCreatedBy() != null ? $cr->getCreatedBy()->getUsername() : ""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() ?? new \DateTime();                

                }                
            }
            if($updatedEntity instanceof ProductionDeExercice){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ProductionDeExercice::class)->findOneBy(['id' => $entityId]);


                if($cr){

                }                
                    $codeCuci = $updatedEntity->getRepertoire()!=null ? $updatedEntity->getRepertoire()->getCodeCuci()."/".$updatedEntity->getAnneeFinanciere():"";
                    
                    $owner = $updatedEntity->getCreatedBy()!=null ? $updatedEntity->getCreatedBy()->getUsername() : ""; 
                    // $owner = $updatedEntity->getCreatedBy()->getUserIdentifier();
                    
                    $created_at = $updatedEntity->getCreatedAt() ?? new \DateTime();                

            }
            if($updatedEntity instanceof AchatProduction){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(AchatProduction::class)->findOneBy(['id' => $entityId]);


                if($cr){

                }                
                    $codeCuci = $updatedEntity->getRepertoire()!=null ? $updatedEntity->getRepertoire()->getCodeCuci()."/".$updatedEntity->getAnneeFinanciere():"";
                    
                    $owner = $updatedEntity->getCreatedBy()!=null ? $updatedEntity->getCreatedBy()->getUsername() : ""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $updatedEntity->getCreatedAt() ?? new \DateTime();                

            }
            if($updatedEntity instanceof BilanSmt){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(BilanSmt::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere():"";
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername() : ""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() ?? new \DateTime();                
                }                

            }
            if($updatedEntity instanceof ComptederesultatSmt){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ComptederesultatSmt::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere():"";
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername() : ""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    // $created_at = $cr->getCreatedAt()!= null ? $cr->getCreatedAt() :"";                
                    $created_at = $cr->getCreatedAt() ?? new \DateTime() ;                
                }                

            }
            if($updatedEntity instanceof Repertoire){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Repertoire::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getCodeCuci()."/".($cr->getCreatedAt()->format('Y')-1) ?? "";
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getPrenomNom() : ""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() ?? new \DateTime();                
                }                

            }


            // get table name
            $tableName = $metaData->getTableName();

            foreach ($changeSet as $fieldName => $changes) {
                $oldValue = array_key_exists(0, $changes) ? $changes[0] : null;
                $newValue = array_key_exists(1, $changes) ? $changes[1] : null;
                // $columnName = $metaData->getFieldMapping($fieldName)['columnName'];
                // avec getColumnName(), Si le nom de colonne du champ est introuvable, le nom de champ donné est renvoyé.
                $columnName = $metaData->getColumnName($fieldName);

                if ($oldValue !== $newValue) {
                    $oldValue = $this->convertValueToString($oldValue);
                    $newValue = $this->convertValueToString($newValue);

                    $logChange = $this->logChangesService->logEntityUpdate(
                        $tableName,
                        $entityId,
                        $columnName,
                        $oldValue,
                        $newValue,             
                        $codeCuci,
                        $created_at,
                        $owner
            
                    );

                    $entityManager->persist($logChange);

                    $logMetadata = $entityManager->getClassMetadata(DbChange::class);
                    $unitOfWork->computeChangeSet($logMetadata, $logChange);
                }
            }
        }

        foreach ($deletedEntities as $deletedEntity) {
            // skip for LogChange entity
            if ($deletedEntity instanceof DbChange) {
                continue;
            }
            if ($deletedEntity instanceof ProductionDeExerciceUtil) {
                continue;
            }
            if ($deletedEntity instanceof AchatProductionUtil) {
                continue;
            }
            if ($deletedEntity instanceof SuiviMaterielMobilierUtilSmt) {
                continue;
            }
            if ($deletedEntity instanceof JournalTresorerieSmtUtil) {
                continue;
            }
            if ($deletedEntity instanceof JournalDettesPayerSmtUtil) {
                continue;
            }
            if ($deletedEntity instanceof JournalCreancesImpayeesSmtUtil) {
                continue;
            }
            if ($deletedEntity instanceof EtatDesStocksSmtUtil) {
                continue;
            }
            if ($deletedEntity instanceof DettesCreancesSmtUtil) {
                continue;
            }

            if ($deletedEntity instanceof NINinea) {
                continue;
            }
            if ($deletedEntity instanceof NiNineaproposition) {
                continue;
            }
            if ($deletedEntity instanceof NiActivite) {
                continue;
            }
            if ($deletedEntity instanceof Ninproduits) {
                continue;
            }
            if ($deletedEntity instanceof NiDirigeant) {
                continue;
            }
            if ($deletedEntity instanceof NiActiviteEconomique) {
                continue;
            }
            if ($deletedEntity instanceof NiCoordonnees) {
                continue;
            }
            if ($deletedEntity instanceof NiPersonne) {
                continue;
            }

            if ($deletedEntity instanceof Repertoire) {
                continue;
            }

            if ($deletedEntity instanceof User) {
                continue;
            }
            if ($deletedEntity instanceof Qualite	) {
                continue;
            }            
            if ($deletedEntity instanceof SystemeComptabilite	) {
                continue;
            }            
            if ($deletedEntity instanceof FormeJuridique	) {
                continue;
            }            

            
            
            // get metadata
            $entityClassName = get_class($deletedEntity);
            $metaData = $entityManager->getClassMetadata($entityClassName);

            // get entity id
            $entityId = $this->getEntityId($unitOfWork, $deletedEntity);


            // customization pour obtenir createdAt, repertoire, createdBy

            $codeCuci = "";
            $created_at = new \DateTime("");
            $owner = "";
            $cr= "";

            if($deletedEntity instanceof CompteDeResultats){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(CompteDeResultats::class)->findOneBy(['id' => $entityId]);
                
                $codeCuci = $cr->getCuciRepCode()->getCodeCuci();
                
                $created_at = $deletedEntity->getCreatedAt();                
                
                 # $owner = $cr->getCreatedBy()->getUsername();
                $owner = $deletedEntity->getCreatedBy()->getUserIdentifier();
            }

            if($deletedEntity instanceof FluxDesTresoreries){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(FluxDesTresoreries::class)->findOneBy(['id' => $entityId]);
                
                $codeCuci = $cr->getCuciRepCode()->getCodeCuci();
                
                $created_at = $deletedEntity->getCreatedAt();                
                
                # $owner = $cr->getCreatedBy()->getUsername(); 
               
                $owner = $deletedEntity->getModifiedBy()!=null ?  $deletedEntity->getModifiedBy()->getUserIdentifier():"";
            }




            if($deletedEntity instanceof Bilan){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Bilan::class)->findOneBy(['id' => $entityId]);

                if($cr){

                    $codeCuci = $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere();

                    # $owner = $cr->getModifiedBy()->getUserIdentifier(); 
                     
                    $owner = $cr->getModifiedBy()!=null ?  $cr->getModifiedBy()->getUsername():""; 
                    
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at =  $cr->getCreatedAt();                

                }                
            }
            if($deletedEntity instanceof ImmoBrut){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ImmoBrut::class)->findOneBy(['id' => $entityId]);



                if($cr){

                   # $codeCuci = $updatedEntity->getRepertoire()->getCodeCuci();
                    $codeCuci = $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere();

                    # $owner = $cr->getModifiedBy()->getUserIdentifier(); 
                    # $owner = $updatedEntity->getModifiedby()->getUserIdentifier(); 
                   
                    $owner = $cr->getModifiedBy()!=null ?  $cr->getModifiedBy()->getUsername():""; 
                    
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at = $cr->getCreatedAt();                

                }                
            }
            if($deletedEntity instanceof CuciImmoPlus){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(CuciImmoPlus::class)->findOneBy(['id' => $entityId]);

                if($cr){
                    $codeCuci = $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere();
                   
                    $owner = $cr->getModifiedBy()!=null ?  $cr->getModifiedBy()->getUsername():"";                     
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at = $cr->getCreatedAt();                

                }                
            }
            if($deletedEntity instanceof Effectifs){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Effectifs::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere();
                    
                    
                    $owner = $cr->getCreatedBy()!=null ?  $cr->getCreatedBy()->getUsername():""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() != null ? $cr->getCreatedAt() : "";                

                }                
            }
            if($deletedEntity instanceof ProductionDeExercice){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ProductionDeExercice::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere();
                    
                   
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername():"";  
                    
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt()!=null ? $cr->getCreatedAt() : "";                

                }                
            }
            if($deletedEntity instanceof AchatProduction){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(AchatProduction::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere();
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername():""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt()!=null ? $cr->getCreatedAt():"";                

                }                
            }
            

                

            // get table name
            $tableName = $metaData->getTableName();

            $logChange = $this->logChangesService->logEntityDelete(
                $tableName,
                $entityId, 
                $codeCuci,
                $created_at,
                $owner
    
            );

            $entityManager->persist($logChange);

            $logMetadata = $entityManager->getClassMetadata(DbChange::class);
            $unitOfWork->computeChangeSet($logMetadata, $logChange);
        }
    }

    /**
     * @param PostFlushEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        foreach ($this->insertedEntities as $insertedEntity) {
            if ($insertedEntity instanceof DbChange) {
                continue;
            }

            if ($insertedEntity instanceof ProductionDeExerciceUtil) {
                continue;
            }
            if ($insertedEntity instanceof AchatProductionUtil) {
                continue;
            }
            if ($insertedEntity instanceof SuiviMaterielMobilierUtilSmt) {
                continue;
            }
            if ($insertedEntity instanceof JournalTresorerieSmtUtil) {
                continue;
            }
            if ($insertedEntity instanceof JournalDettesPayerSmtUtil) {
                continue;
            }
            if ($insertedEntity instanceof JournalCreancesImpayeesSmtUtil) {
                continue;
            }
            if ($insertedEntity instanceof EtatDesStocksSmtUtil) {
                continue;
            }
            if ($insertedEntity instanceof DettesCreancesSmtUtil) {
                continue;
            }
            if ($insertedEntity instanceof User) {
                continue;
            }
            if ($insertedEntity instanceof NiNineaproposition) {
                continue;
            }
            if ($insertedEntity instanceof CuciMigLog) {
                continue;
            }
            if ($insertedEntity instanceof NiDirigeant) {
                continue;
            }
            if ($insertedEntity instanceof NiActiviteEconomique) {
                continue;
            }
            if ($insertedEntity instanceof NINinea) {
                continue;
            }
            if ($insertedEntity instanceof NiPersonne) {
                continue;
            }
            if ($insertedEntity instanceof Filiales) {
                continue;
            }
            if ($insertedEntity instanceof MembreConseil) {
                continue;
            }
            if ($insertedEntity instanceof Actionnaire) {
                continue;
            }
            if ($insertedEntity instanceof Dirigeant) {
                continue;
            }
            if ($insertedEntity instanceof CommissairesComptes) {
                continue;
            }
            if ($insertedEntity instanceof Activities 	) {
                continue;
            }
            if ($insertedEntity instanceof NiActivite 	) {
                continue;
            }
            if ($insertedEntity instanceof Ninproduits 	) {
                continue;
            }
            if ($insertedEntity instanceof NiAdministration 	) {
                continue;
            }
            // entity liées au Repertoire
            if ($insertedEntity instanceof SequenceNumeroCUCI 	) {
                continue;
            }
            
            // entity associees a NiNinea entity
            if ($insertedEntity instanceof NINinea 	) {
                continue;
            }
            if ($insertedEntity instanceof NiNineaproposition 	) {
                continue;
            }
            if ($insertedEntity instanceof NiCoordonnees 	) {
                continue;
            }            
            if ($insertedEntity instanceof Qualite	) {
                continue;
            }            
            if ($insertedEntity instanceof Activities) {
                continue;
            }            
            if ($insertedEntity instanceof SystemeComptabilite) {
                continue;
            }            
            if ($insertedEntity instanceof FormeJuridique) {
                continue;
            }            
            
            
            
            // get metadata
            $entityClassName = get_class($insertedEntity);
            $metaData = $entityManager->getClassMetadata($entityClassName);
            
            // get table name
            $tableName = $metaData->getTableName();
            
            // get entity id
            $entityId = $this->getEntityId($unitOfWork, $insertedEntity);
            
            
            // customization pour obtenir createdAt, repertoire, createdBy

            $codeCuci = "";
            $created_at = new \DateTime("");
            $owner = "";
            $cr= "";

           
            
            if($insertedEntity instanceof CompteDeResultats){
                
                // TODO somethink here to find codeCuci
                $obj = $entityManager->getRepository(CompteDeResultats::class)->findOneBy(['id' => $entityId]);
                
                $codeCuci = $obj->getCuciRepCode()!=null ? $obj->getCuciRepCode()->getCodeCuci()."/".$obj->getAnneeFinanciere()."/".$obj->getRefCode():"";
                
                $created_at = $insertedEntity->getCreatedAt() ??  new \DateTime();                
                
                 # $owner = $obj->getCreatedBy()->getUsername();
                $owner = $insertedEntity->getCreatedAt()!=null ? $insertedEntity->getCreatedBy()->getUserIdentifier():"";
            }

            if($insertedEntity instanceof FluxDesTresoreries){
                
                // TODO somethink here to find codeCuci
                $obj = $entityManager->getRepository(FluxDesTresoreries::class)->findOneBy(['id' => $entityId]);
                
                $codeCuci = $obj->getCuciRepCode()!=null ? $obj->getCuciRepCode()->getCodeCuci()."/".$obj->getAnneeFinanciere()."/".$obj->getRefCode():"";
                
                $created_at = $insertedEntity->getCreatedAt() ??  new \DateTime();                
                
                # $owner = $obj->getCreatedBy()->getUsername(); 
                $owner = $insertedEntity->getModifiedBy()!=null ? $insertedEntity->getModifiedBy()->getUserIdentifier():"";
            }



            if($insertedEntity instanceof Bilan){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Bilan::class)->findOneBy(['id' => $entityId]);

                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere()."/".$cr->getRefCode():"";

                    # $owner = $cr->getModifiedBy()->getUserIdentifier(); 
                    $owner = $cr->getModifiedBy()!=null ? $cr->getModifiedBy()->getUsername():"";   
                    
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at =  $cr->getCreatedAt() ??  new \DateTime();                

                }                
            }
            if($insertedEntity instanceof ImmoBrut){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ImmoBrut::class)->findOneBy(['id' => $entityId]);



                if($cr){

                   # $codeCuci = $updatedEntity->getRepertoire()->getCodeCuci();
                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere()."/".$cr->getRefCode():"";

                    # $owner = $cr->getModifiedBy()->getUserIdentifier(); 
                    # $owner = $updatedEntity->getModifiedby()->getUserIdentifier(); 
                    $owner = $cr->getModifiedby()!=null ? $cr->getModifiedby()->getUsername():"";   
                    
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at = $cr->getCreatedAt() ??  new \DateTime();                

                }                
            }
            if($insertedEntity instanceof CuciImmoPlus){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(CuciImmoPlus::class)->findOneBy(['id' => $entityId]);

                if($cr){
                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere()."/".$cr->getRefCode():"";
                    $owner = $cr->getModifiedBy()!=null ? $cr->getModifiedBy()->getUsername():"";                     
                    
                    # $created_at = $updatedEntity->getCreatedAt();                
                    $created_at = $cr->getCreatedAt() ??  new \DateTime();                

                }                
            }
            if($insertedEntity instanceof Effectifs){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Effectifs::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere()."/".$cr->getRefCode():"";
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername():""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() ??  new \DateTime();                

                }                
            }
            if($insertedEntity instanceof ProductionDeExercice){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ProductionDeExercice::class)->findOneBy(['id' => $entityId]);


                if($cr){

                }                
                    $codeCuci = $insertedEntity->getRepertoire()!=null ? $insertedEntity->getRepertoire()->getCodeCuci()."/".$insertedEntity->getAnneeFinanciere():"";
                    
                    $owner = $insertedEntity->getCreatedBy()!=null ? $insertedEntity->getCreatedBy()->getUsername() :""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $insertedEntity->getCreatedAt() ??  new \DateTime();                

            }
            if($insertedEntity instanceof AchatProduction){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(AchatProduction::class)->findOneBy(['id' => $entityId]);


                if($cr){

                }                
                    $codeCuci = $insertedEntity->getRepertoire()!=null ? $insertedEntity->getRepertoire()->getCodeCuci()."/".$insertedEntity->getAnneeFinanciere():"";
                    
                    $owner = $insertedEntity->getCreatedBy()!=null ? $insertedEntity->getCreatedBy()->getUsername():""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $insertedEntity->getCreatedAt() ??  new \DateTime();                

            }
            if($insertedEntity instanceof BilanSmt){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(BilanSmt::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere()."/".$cr->getRefCode():"";
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername():""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() ??  new \DateTime();                
                }                

            }
            if($insertedEntity instanceof ComptederesultatSmt){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(ComptederesultatSmt::class)->findOneBy(['id' => $entityId]);


                if($cr){

                    $codeCuci = $cr->getRepertoire()!=null ? $cr->getRepertoire()->getCodeCuci()."/".$cr->getAnneeFinanciere()."/".$cr->getRefCode():"";
                    
                    $owner = $cr->getCreatedBy()!=null ? $cr->getCreatedBy()->getUsername():""; 
                    # $owner = $updatedEntity->getModifiedBy()->getUserIdentifier();
                    
                    $created_at = $cr->getCreatedAt() ??  new \DateTime();                
                }                

            }

            if($insertedEntity instanceof Repertoire){
                
                // TODO somethink here to find codeCuci
                $cr = $entityManager->getRepository(Repertoire::class)->findOneBy(['id' => $entityId]);


                if($cr){

                }                
                    $codeCuci = $insertedEntity->getCodeCuci()."/".($insertedEntity->getCreatedAt()->format('Y')-1) ?? "";
                    
                    $owner = $insertedEntity->getCreatedBy()!=null ? $insertedEntity->getCreatedBy()->getPrenomNom() : ""; 
                    # $owner = $insertedEntity->getModifiedBy()->getUserIdentifier();
                    
                    # $created_at = $insertedEntity->getCreatedAt()!= null ? $insertedEntity->getCreatedAt() :"";                
                    $created_at = $insertedEntity->getCreatedAt() ?? new \DateTime();                

            }
                
            if($insertedEntity instanceof Repertoire){
                $logChange = $this->logChangesService->logEntityInsertNewUnit(
                    $tableName,
                    $entityId,             
                    $codeCuci,
                    $created_at,
                    $owner            
                );
                    
            }else {
                
                $logChange = $this->logChangesService->logEntityInsert(
                    $tableName,
                    $entityId,             
                    $codeCuci,
                    $created_at,
                    $owner    
        
                );

            }

            $entityManager->persist($logChange);
            $entityManager->flush();
        }
    }

    /**
     * @param UnitOfWork $unitOfWork
     * @param $entity
     * @return integer
     */
    private function getEntityId(UnitOfWork $unitOfWork, $entity)
    {
        $identifier = $unitOfWork->getEntityIdentifier($entity);
        $idFieldName = array_key_first($identifier);
        $entityId = $identifier[$idFieldName];

        return $entityId;
    }

    public function convertValueToString($value): string
    {
        if($value instanceof \DateTime){
            $value = $value->format(self::DATETIME_FORMAT);
        }

        return (string) $value;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'onFlush',
            'postFlush'
        ];
    }
}
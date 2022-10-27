<?php

namespace App\Services;

use App\Entity\DbChange;
use App\Entity\User;
use DateTime;
use Symfony\Component\Security\Core\Security;

class LogChangesService
{
    private const ACTION_UPDATE = 'update';
    private const ACTION_INSERT = 'Nouvelle unite';
    private const ACTION_INSERT2 = 'Nouveau enregistrement';
    private const ACTION_DELETE = 'delete';
    private const DEFAULT_USER_ID = 1;


    
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function logEntityUpdate(
        string $tableName,
        string $entityId,
        string $columnName,
        string $oldValue,
        string $newValue,
        string $codeCuci,
        DateTime $dateSaisie,
        string $owner
    ): DbChange {

        
        $dbChange = new DbChange();
        $dbChange
            ->setCreatedAt(new \DateTime())
            ->setUserId($this->getAuthorizedUserId())
            ->setTableName($tableName)
            ->setEntityId($entityId)
            ->setAction(self::ACTION_UPDATE)
            ->setFieldName($columnName)
            ->setOldValue($oldValue)
            ->setNewValue($newValue)
            ->setCodeCuci($codeCuci)
            ->setDateSaisie($dateSaisie)
            ->setOwner($owner)
            ;

        return $dbChange;
    }

    /**
     * function pour ecouter un nouveau enregistrement d une table des etats financiers
     *
     * @param string $tableName
     * @param string $entityId
     * @param string $codeCuci
     * @param DateTime $dateSaisie
     * @param string $owner
     * @return DbChange
     */
    public function logEntityInsert(string $tableName, 
                                    string $entityId,
                                    string $codeCuci,
                                    DateTime $dateSaisie,
                                    string $owner
                                    ): DbChange
    {
        $dbChange = new DbChange();
        $dbChange
            ->setCreatedAt(new \DateTime())
            ->setUserId($this->getAuthorizedUserId())
            ->setTableName($tableName)
            ->setEntityId($entityId)
            ->setAction(self::ACTION_INSERT2)
            ->setFieldName('')
            ->setOldValue('')
            ->setNewValue('')
            ->setCodeCuci($codeCuci)
            ->setDateSaisie($dateSaisie)
            ->setOwner($owner)
            ;
        return $dbChange;
    }

    /**
     * Function pour ecouter la saisie d une nouvelle unite du repertoire
     *
     * @param string $tableName
     * @param string $entityId
     * @param string $codeCuci
     * @param DateTime $dateSaisie
     * @param string $owner
     * @return DbChange
     */
    public function logEntityInsertNewUnit(string $tableName, 
                                    string $entityId,
                                    string $codeCuci,
                                    DateTime $dateSaisie,
                                    string $owner
                                    ): DbChange
    {
        $dbChange = new DbChange();
        $dbChange
            ->setCreatedAt(new \DateTime())
            ->setUserId($this->getAuthorizedUserId())
            ->setTableName($tableName)
            ->setEntityId($entityId)
            ->setAction(self::ACTION_INSERT)
            ->setFieldName('')
            ->setOldValue('')
            ->setNewValue('')
            ->setCodeCuci($codeCuci)
            ->setDateSaisie($dateSaisie)
            ->setOwner($owner)
            ;
        return $dbChange;
    }


    public function logEntityDelete(string $tableName, 
                                    string $entityId,
                                    string $codeCuci,
                                    DateTime $dateSaisie,
                                    string $owner
                                    ): DbChange
    {
        $dbChange = new DbChange();
        $dbChange
            ->setCreatedAt(new \DateTime())
            ->setUserId($this->getAuthorizedUserId())
            ->setTableName($tableName)
            ->setEntityId($entityId)
            ->setAction(self::ACTION_DELETE)
            ->setFieldName('')
            ->setOldValue('')
            ->setNewValue('')
            ->setCodeCuci($codeCuci)
            ->setDateSaisie($dateSaisie)
            ->setOwner($owner)
            ;

        return $dbChange;
    }

    /**
     * @var User $user 
     *TODO use real user id to know who updated 
     */
    private function getAuthorizedUserId(): string
    {   
        $user = $this->security->getUser();

        # return (string) self::DEFAULT_USER_ID;
        if(empty($user)){

            return (string) self::DEFAULT_USER_ID; 

        }

        $userId = $user->getUserIdentifier(); # return le username
        #$userId = $user->getPrenomNom(); # return le username

       # $req = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $userId]);


        return  (string) $userId;

    }
}
<?php

/**
 * Class SDCOrganisation
 * Helps manage organisations
 */
class SDCOrganisation
{
    /**
     * @var Object Stores the organisation as an object
     */
    public $obj;

    /**
     * SDCOrganisation constructor.
     * @param String $orgID ID of the organisation
     * @throws Exception
     */
    public function __construct($orgID)
    {

        global $connection;

        $sql = "SELECT * FROM organisations WHERE orgid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$orgID);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('OrganisationNotFoundException');
        }

        $this->obj = $result->fetch_object();

    }

    /**
     * Gets the ID of an organisation by its identifier
     * @param String $identifier Identifier to look up
     * @return mixed False on fail, string ID on success
     * @throws Exception
     */
    public static function getIDFromIdentifier($identifier){

        global $connection;

        $sql = "SELECT * FROM organisations WHERE identifier=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$identifier);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('OrganisationNotFoundException');
        }

        return $result->fetch_object()->orgid;

    }

    /**
     * @param SDCUser $user User to add to the org
     * @param SDCUser $adder Adder User
     * @param String $perms Permissions to give to the user, defaults to Admin
     */
    public function addMember($user,$adder,$perms = "Admin"){

        $orgID = $this->obj->orgid;

        global $connection;

        $sql = "INSERT INTO organisationmembers (userid, orgid, perms, adderid, adddate) VALUES (?,?,?,?,?)";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $user = $user->obj->id;
        $adder = $adder->obj->id;
        $time = time();

        $stmt->bind_param("issii",$user,$orgID,$perms,$adder,$time);

        $stmt->execute();

    }

    /**
     * @param SDCUser $user User to delete from the org
     */
    public function deleteMember($user){

        $orgID = $this->obj->id;

        global $connection;

        $sql = "DELETE FROM organisationmembers WHERE userid=? and orgid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $user = $user->obj->id;

        $stmt->bind_param("is",$user,$orgID);

        $stmt->execute();

    }

    /**
     * Creates a personal team
     * @param String $ownerUsername Username of the owner of personal team
     * @return SDCOrganisation
     * @throws Exception
     */
    public static function createPersonalTeam($ownerUsername){

        try {
            $owner = new SDCUser($ownerUsername);
        } catch (Exception $e) {
            throw new Exception('UserNotFoundException');
        }

        $id = $owner->obj->id;

        global $connection;

        $sql = "INSERT INTO organisations (ownerid, orgid, orgname, orgdescription, orgcreation, orgstatus, orgtype, identifier) VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $orgID = rand_md5_hash();
        $orgName = "Personal - ".$owner->obj->username;
        $orgIdentifier = "p.".$owner->obj->username;
        $orgDesc = "This is your personal team that you can use for personal projects.";
        $time = time();
        $status = "PENDING_VALIDATION";
        $type = "PERSONAL";

        $stmt->bind_param("isssisss",$id, $orgID,$orgName,$orgDesc,$time,$status,$type,$orgIdentifier);

        $stmt->execute();

        return new SDCOrganisation($orgID);

    }

}
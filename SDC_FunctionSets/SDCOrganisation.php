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

    /**
     * Creates a team
     * @param String $ownerUsername Username of the owner of the team
     * @param String $reverseDomain Reverse domain of the team
     * @param String $name Name of the team.
     * @return SDCOrganisation
     * @throws Exception
     */
    public static function createTeam($ownerUsername,$reverseDomain,$name){

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
        $orgName = $name;
        $orgIdentifier =$reverseDomain;
        $orgDesc = "This is a team that you can use with your colleagues.";
        $time = time();
        $status = "PENDING_VALIDATION";
        $type = "ORGANISATION";

        $stmt->bind_param("isssisss",$id, $orgID,$orgName,$orgDesc,$time,$status,$type,$orgIdentifier);

        $stmt->execute();

        return new SDCOrganisation($orgID);

    }

    /**
     * Sets a meta for an organisation.
     * @param String $f Field Name
     * @param String $v Field Value
     */
    public function saveMeta($f,$v){
        global $connection;
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT metaval FROM orgmeta WHERE metaname=? AND orgid=?");
        $stmt->bind_param("ss",$f,$this->obj->orgid);
        $stmt->execute();
        $res = $stmt->get_result();
        $numrows = $res->num_rows;

        if($numrows == 1){
            $delete_stmt = $connection->stmt_init();
            $delete_stmt->prepare("DELETE FROM orgmeta WHERE metaname=? AND orgid=?");
            $delete_stmt->bind_param("ss",$f,$this->obj->orgid);
            $delete_stmt->execute();
        }

        $addval_stmt = $connection->stmt_init();
        $addval_stmt->prepare("INSERT INTO orgmeta (orgid, metaname, metaval) VALUES (?,?,?)");
        $addval_stmt->bind_param("sss",$this->obj->orgid,$f,$v);
        $addval_stmt->execute();
    }

    /**
     * Gets a meta for an organisation.
     * @param String $f Field Name
     * @return false|mixed
     */
    public function getMeta($f){
        global $connection;
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT metaval FROM orgmeta WHERE metaname=? AND orgid=?");
        $stmt->bind_param("ss",$f,$this->obj->orgid);
        $stmt->execute();
        $res = $stmt->get_result();
        $numrows = $res->num_rows;
        if($numrows == 1){

            $r = $res->fetch_assoc();
            return $r['metaval'];

        }

        return false;

    }

    /**
     * Deletes a meta
     * @param String $f Meta field name
     */
    public function deleteMeta($f){

        global $connection;
        $delete_stmt = $connection->stmt_init();
        $delete_stmt->prepare("DELETE FROM orgmeta WHERE metaname=? AND orgid=?");
        $delete_stmt->bind_param("ss",$f,$this->obj->orgid);
        $delete_stmt->execute();

    }

    /**
     * Gets a users role in an organisation.
     * @param SDCUser $u User to check
     * @return false|mixed
     */
    public function getMemberRole($u){

        global $connection;
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT perms FROM organisationmembers WHERE userid=?");
        $stmt->bind_param("s",$u->obj->id);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows != 0){

            $r = $res->fetch_assoc();
            return $r['perms'];

        } else {
            return false;
        }

    }

    /**
     * Gets the account status in a human readable form.
     * @return string A String that contains the account data in a human readable form.
     */
    public function getNiceAccountState(){

        switch ($this->obj->orgstatus){

            case "PENDING_VALIDATION":
                return "Pending Verification";
                break;

            case "ACTIVE":
                return "Active";
                break;

            case "SUSPENDED":
                return "Suspended";
                break;

            case "BANNED":
                return "Banned";
                break;

            case "OFFICIAL_ACTIVE":
                return "Active and Official";
                break;

            case "IN_REVIEW":
                return "Being Validated by Skyfallen";
                break;

        }

        return false;

    }

    /**
     * Updates a org's profile
     * @param String $name New Name
     * @throws Exception
     */
    public function saveNewProfile($name){

        global $connection;

        $sql = "UPDATE organisations SET orgname=?, orgstatus='PENDING_VALIDATION' WHERE orgid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $oI = $this->obj->orgid;

        $stmt->bind_param("ss",$name,$oI);

        $stmt->execute();

        $newParse = new SDCOrganisation($this->obj->orgid);

        $this->obj = $newParse->obj;

    }

    /**
     * Lists an organisations members
     */
    public function listMembers(){

        global $connection;

        $sql = "SELECT * FROM organisationmembers WHERE orgid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $oI = $this->obj->orgid;

        $stmt->bind_param("s",$oI);

        $stmt->execute();

        $a = Array();

        $r = $stmt->get_result();

        if($r->num_rows == 0){

            return $a;

        } else {

            while($row = $r->fetch_assoc()){
                array_push($a,$row['userid']);
            }

            return $a;

        }

    }

    /**
     * Removes a user from an org
     * @param SDCUser $user Member to add to the org
     */
    public function removeMember($user){

        $orgID = $this->obj->orgid;

        global $connection;

        $sql = "DELETE FROM organisationmembers WHERE orgid=? AND userid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $uI = $user->obj->id;
        $oI = $this->obj->orgid;

        $stmt->bind_param("ss",$oI,$uI);

        $stmt->execute();

    }


}
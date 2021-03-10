<?php

/**
 * Class SDCApp
 * Allows manage SDC Apps
 */
class SDCApp
{

    public $obj;

    /**
     * SDCApp constructor.
     * @param String $appID ID of the app
     * @throws Exception
     */
    public function __construct($appID)
    {

        global $connection;

        $sql = "SELECT * FROM apps WHERE appid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$appID);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('AppNotFoundException');
        }

        $this->obj = $result->fetch_object();

    }

    /**
     * Checks if a identifier exists in the database
     * @param String $identifier Identifier to look up
     * @return bool False if does not, true if it does.
     */
    public static function identifierExists($identifier){

        global $connection;

        $sql = "SELECT * FROM apps WHERE identifier=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$identifier);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows != 1){
            return false;
        }

        return true;

    }

    /**
     * Checks if an ID exists in the database
     * @param String $id ID to look up
     * @return bool False if does not, true if it does.
     */
    public static function idExists($id){

        global $connection;

        $sql = "SELECT * FROM apps WHERE appid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$id);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows != 1){
            return false;
        }

        return true;

    }

    /**
     * Deletes an app
     * @param SDCOrganisation $org to verify permissions
     * @return bool False if fail, true if success.
     */
    public function deleteApp($org){

        $appid = $this->obj->appid;
        $orgid = $org->obj->orgid;

        global $connection;

        $sql = "SELECT * FROM apps WHERE appid=? AND ownerorg=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("ss",$appid,$orgid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows != 1){
            return false;
        }

        $sql = "DELETE FROM apps WHERE appid=?";

        $stmtb = $connection->stmt_init();

        $stmtb->prepare($sql);

        $stmtb->bind_param("s",$appid);

        $stmtb->execute();

        return true;

    }

    /**
     * @param SDCOrganisation $org Org of the new app
     * @param String $identifier Identifier of the new app
     * @param String $name Name of the new app
     * @return SDCApp|bool
     * @throws Exception
     */
    public static function createApp($org,$identifier,$name){

        if(SDCApp::identifierExists($identifier)){
            return false;
        }

        $id = $org->obj->orgid;

        global $connection;

        $sql = "INSERT INTO apps (ownerorg, appid, appname, appdescription, appstatus, appcreation, identifier) VALUES (?,?,?,?,?,?,?)";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $appID = rand_md5_hash();
        $appDesc = "";
        $time = time();
        $status = "IN_USE";
        $type = "PERSONAL";

        $stmt->bind_param("sssssss",$id,$appID,$name,$appDesc,$status,$time,$identifier);

        $stmt->execute();

        $r =  new SDCApp($appID);

        return $r;

    }

    /**
     * Lists all apps that are owned by a given organisation
     * @param SDCOrganisation $org Organisation to lookup the apps of
     * @return array Containing the apps as SDCApp
     * @throws Exception
     */
    public static function listOrgApps($org){

        global $connection;

        $sql = "SELECT * FROM apps WHERE ownerorg=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $orgID = $org->obj->orgid;

        $stmt->bind_param("s",$orgID);

        $stmt->execute();

        $res = $stmt->get_result();

        $apps = Array();

        if($res->num_rows > 0){

            while($row = $res->fetch_assoc()){

                array_push($apps, new SDCApp($row['appid']));

            }

        }

        return $apps;

    }

}
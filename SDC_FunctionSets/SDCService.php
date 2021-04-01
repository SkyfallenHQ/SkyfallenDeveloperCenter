<?php

/**
 * Class SDCService
 * Allows manage app services
 */
class SDCService
{

    public $obj;

    /**
     * SDCService constructor.
     * @param String $svcid Service Provision ID
     * @throws Exception
     */
    public function __construct($svcid)
    {

        global $connection;

        $sql = "SELECT * FROM appservices WHERE provisionid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$svcid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('ServiceProvisionNotFoundException');
        }

        $this->obj = $result->fetch_object();

    }

    /**
     * Provisions a service for an app.
     * @param SDCApp $app App to provision
     * @param String $svc Service to provision
     * @return SDCService
     * @throws Exception
     */
    public static function provisionService($app,$svc){

        $appIdentifier = $app->obj->identifier;
        $appID = $app->obj->appid;

        global $connection;

        $sql = "INSERT INTO appservices (appid, service, serviceid, servicesecret, provisionid) VALUES (?,?,?,?,?)";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $svcID = rand_md5_hash();
        $svcSecret = rand_md5_hash();
        $svcPID = $appIdentifier.".".$svc;

        $stmt->bind_param("sssss",$appID,$svc,$svcID,$svcSecret,$svcPID);

        $stmt->execute();

        $svx = new SDCService($svcPID);

        return $svx;

    }

    /**
     * Deletes a provision
     */
    public function delete(){

        $pid = $this->obj->provisionid;

        global $connection;

        $sql = "DELETE FROM appservices WHERE provisionid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$pid);

        $stmt->execute();

    }

    /**
     * Safely parses an app service meta
     * @param String $fieldName Name of the service meta
     * @return string Value of the field
     */
    public function safeProvisionMeta($fieldName){

        if(property_exists($this->obj, $fieldName)) {

            return $this->obj->{$fieldName};

        } else {

            return "";

        }

    }

    /**
     * Validates Service Details for a service
     * @param String $svc_id ID of the service
     * @param String $service_secret Secret of the service
     * @return bool depending on the status of the test
     */
    public function validateCredentials($svc_id,$service_secret){

        return $this->obj->serviceid == $svc_id and $this->obj->servicesecret == $service_secret;

    }

}
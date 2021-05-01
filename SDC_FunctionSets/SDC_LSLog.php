<?php

/**
 * Class SDC_LSLog
 * Allows manage the public logging service
 */
class SDC_LSLog
{

    public $obj;

    /**
     * SDC_LSLog constructor.
     * @param String $logid Service Log ID
     * @param String $svcid Service ID
     * @throws Exception
     */
    public function __construct($logid,$svcid)
    {

        global $connection;

        $sql = "SELECT * FROM applogservice WHERE logid=? and svcid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("ss",$logid,$svcid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('ServiceLogNotFoundException');
        }

        $this->obj = $result->fetch_object();

    }

    /**
     * Logs an event
     * @param String $svcid Service ID of the App
     * @param String $type Type of the event
     * @param String $data JSON Event Data
     */
    public static function log($svcid,$type,$data){


        global $connection;

        $sql = "INSERT INTO applogservice (logid,svcid,time,logtype,logdata) VALUES (?,?,?,?,?)";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $t = time();

        $id = rand_md5_hash();

        $stmt->bind_param("ssiss",$id,$svcid,$t,$type,$data);

        $stmt->execute();

        return $id;

    }

    /**
     * Logs an event
     * @param String $svcid Service ID of the App
     * @return array containing logs
     */
    public static function listLogs($svcid){


        global $connection;

        $sql = "SELECT logid FROM applogservice WHERE svcid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$svcid);

        $stmt->execute();

        $sr = $stmt->get_result();

        $r = array();

        if($sr->num_rows > 0){
            
            while($row = $sr->fetch_assoc()){

                $newobj = new SDC_LSLog($row['logid'],$svcid);
                array_push($r,$newobj);

            }

        }

        return $r;

    }

    /**
     * Clears all logs
     * @param String $svcid Service ID of the App
     */
    public static function clearLogs($svcid){


        global $connection;

        $sql = "DELETE FROM applogservice WHERE svcid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$svcid);

        $stmt->execute();

    }

}
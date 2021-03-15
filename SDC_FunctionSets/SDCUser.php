<?php

/**
 * Class SDCUser
 * Allows manage users.
 */
class SDCUser
{

    public $obj;

    /**
     * SDCUser constructor.
     * @param String $username Username of the user to fetch
     * @throws Exception
     */
    public function __construct($username)
    {

        global $connection;

        $sql = "SELECT * FROM users WHERE username=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$username);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('UserNotFoundException');
        }

        $this->obj = $result->fetch_object();

    }

    /**
     * Checks if a user exists in the database
     * @param String $username Username to check for
     * @return bool false if not, true if it does.
     */
    public static function userExists($username){

        global $connection;

        $sql = "SELECT * FROM users WHERE username=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$username);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows != 1){
            return false;
        }

        return true;


    }

    /**
     * Logs a user in
     */
    public function login(){

        $_SESSION['loginStatus'] = true;
        $_SESSION['user'] = $this;

    }

    /**
     * Creates a user
     * @param String $username Username of the new user
     * @param String $email Email of the new user
     */
    public static function createUser($username, $email){

        global $connection;

        $sql = "INSERT INTO users (username, email, createdate, accountstatus) VALUES (?,?,?,?)";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $time = time();
        $status = "PENDING_VALIDATION";

        $stmt->bind_param("ssis",$username,$email, $time, $status);

        $stmt->execute();

    }

    /**
     * Gets the organisations that the user is a member of.
     * @return array Array consisting of SDCOrganisations that the user is a member of.
     * @throws Exception
     */
    public function getUserOrganisations(){

        global $connection;

        $sql = "SELECT * FROM organisationmembers WHERE userid=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $userID = $this->obj->id;

        $stmt->bind_param("i",$userID);

        $stmt->execute();

        $res = $stmt->get_result();

        $orgs = Array();

        if($res->num_rows > 0){

            while($row = $res->fetch_assoc()){

                array_push($orgs, new SDCOrganisation($row['orgid']));

            }

        }

        return $orgs;

    }

    /**
     * Gets the account status in a human readable form.
     * @return string A String that contains the account data in a human readable form.
     */
    public function getNiceAccountState(){

        switch ($this->obj->accountstatus){

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
     * Safely parses a profile field
     * @param String $fieldName Name of the profile attribute
     * @return string Value of the field
     */
    public function safeParseProfile($fieldName){

        if(property_exists($this->obj, $fieldName)) {

            return $this->obj->{$fieldName};

        } else {

            return "";

        }

    }

    /**
     * Updates a user's credentials
     * @param String $name New Name
     * @param String $surname New Surname
     * @param String $birthdate New Birth Date
     * @param String $phone New Phone
     * @param String $country New Country
     * @param String $role New Job
     * @throws Exception
     */
    public function saveNewProfile($name,$surname,$birthdate,$phone,$country,$role){

        global $connection;

        $sql = "UPDATE users SET name=?, surname=?, bdate=?, phone=?, country=?,job=?, accountstatus='PENDING_VALIDATION' WHERE id=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $userID = $this->obj->id;

        $stmt->bind_param("ssssssi",$name,$surname,$birthdate,$phone,$country,$role,$userID);

        $stmt->execute();

        $newParse = new SDCUser($this->obj->username);

        $this->obj = $newParse->obj;

    }

    /**
     * Sends a user for validation
     */
    public function sendForValidation(){

        global $connection;

        $sql = "UPDATE users SET accountstatus='IN_REVIEW' WHERE id=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $userID = $this->obj->id;

        $stmt->bind_param("i",$userID);

        $stmt->execute();

        $newParse = new SDCUser($this->obj->username);

        $this->obj = $newParse->obj;

    }

    /**
     * Gets a username from ID
     * @param String $userID User ID to look for.
     */
    public static function getUsernameFromID($userID){

        global $connection;

        $sql = "SELECT * FROM users WHERE id=?";

        $stmt = $connection->stmt_init();

        $stmt->prepare($sql);

        $stmt->bind_param("s",$userID);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            throw new Exception('UserNotFoundException');
        }

        return $result->fetch_object()->username;


    }

}
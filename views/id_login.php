<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*        This file contains the functions to login with Skyfallen ID              */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die();

/**
 * Redirects the user to the Skyfallen ID Authorisation
 */

function do_oauth_init(){

    if(ISLOGGEDIN){
        header("Location: ".WEB_URL);
    }

    header("Location: ".IDP_URL."oauth/authorize?client_id=".IDP_ID."&redirect_uri=".urlencode(IDP_CALLBACK)."&response_type=code");

}

/**
 * Handles the oauth callback from Skyfallen ID
 */
function handle_oauth_callback(){

    if(ISLOGGEDIN){
        header("Location: ".WEB_URL);
    }

    if(isset($_GET["code"])){
        //echo "Requesting Authorization Code";
        $url = IDP_URL."oauth/token";
        $data = array(
            'grant_type' => 'authorization_code',
            'code' => $_GET["code"],
            'client_id' => IDP_ID,
            'client_secret' => IDP_SECRET,
            'redirect_uri' => IDP_CALLBACK
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        //var_dump($options);
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            session_destroy();
            die("Token has expired. Please try again. If authorization takes longer than a few seconds try using a better connection");
        }

        $result = file_get_contents(IDP_URL."?oauth=me&access_token=".json_decode($result,true)["access_token"], false);
        $userData = json_decode($result,true);

        if(!SDCUser::userExists($userData['user_login'])) {
            SDCUser::createUser($userData['user_login'], $userData['user_email']);
            $org = SDCOrganisation::createPersonalTeam($userData['user_login']);
            $u = new SDCUser($userData['user_login']);
            $org->addMember($u,$u);
        }

        $u = new SDCUser($userData['user_login']);
        $u->login();
        header("Location: ".WEB_URL);

    } else {

        die("No oauth response was returned.");

    }


}
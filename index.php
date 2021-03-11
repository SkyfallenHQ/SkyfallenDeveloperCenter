<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/* This file is where all requests are redirected to. All file inclusions are here.*/
/***********************************************************************************/

error_reporting(E_ALL);
ini_set("display_errors",1);
ini_set("display_startup_errors",1);

// Define the application's ABSOLUTE FS Path
define("SDC_ABSPATH", dirname(__FILE__));

// Include All Configuration Files
include_once SDC_ABSPATH."/Configuration/UpdaterConfiguration.php";
include_once SDC_ABSPATH."/thisversion.php";

// Unless the installation was complete, the Database Config should exist, if not, present an error.
if((@include_once SDC_ABSPATH . "/Configuration/SkyfallenDeveloperCenterConfiguration.php") === false){

    // Stop further execution
    die("There is no configuration file found.");
}

// Create the htaccess if not exists
if(!file_exists(SDC_ABSPATH . "/.htaccess")){

    // Include the install file
    include_once SDC_ABSPATH."/csc.php";

    // Stop further execution
    die();
}

// Include PRE-SESSION Classes
include_once SDC_ABSPATH."/SDC_FunctionSets/DBSettings.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDC_Router.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDC_CSRF.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDCUser.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDCOrganisation.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDCEmail.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDCApp.php";
include_once SDC_ABSPATH."/SDC_FunctionSets/SDCService.php";

// Include all SCL Libraries
include_once SDC_ABSPATH."/SkyfallenCodeLib/UpdatesConsoleConnector.php";

// Include Mailing Library
include_once SDC_ABSPATH."/Mailer/PHPMailer.php";
include_once SDC_ABSPATH."/Mailer/SMTP.php";
include_once SDC_ABSPATH."/Mailer/OAuth.php";
include_once SDC_ABSPATH."/Mailer/POP3.php";
include_once SDC_ABSPATH."/Mailer/Exception.php";

// Start Session
session_name("SDCSession");
session_start();

// Include POST-SESSION Helpers
include_once SDC_ABSPATH."/SDC_Includes/CSRF_Session_Helper.php";
include_once SDC_ABSPATH."/SDC_Includes/UserSessionHelper.php";

// Include Utility Functions
include_once SDC_ABSPATH."/SDC_Includes/utility_functions.php";

// Include the URL Handler to verify the URL and the request.
include_once SDC_ABSPATH."/URLHandler.php";

// Include the router file to route the URLs
include_once SDC_ABSPATH."/router.php";

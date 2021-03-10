<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*       This file contains helpers to handle the user session and login           */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Stop it!");

// Check if a user is logged and define the constants
if(isset($_SESSION['loginStatus']) && $_SESSION['loginStatus']){
    define("ISLOGGEDIN",true);
} else {
    define("ISLOGGEDIN",false);
}
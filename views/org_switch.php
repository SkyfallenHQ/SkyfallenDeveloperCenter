<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file contains the function to render the switch org page            */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Switch organisation page' page
 */
function render_org_switch($oid){

    $newOrg = new SDCOrganisation($oid);
    if(!$newOrg->getMemberRole($_SESSION['user'])){
        include_once SDC_ABSPATH."/SDC_Includes/404.php";
        die();
    } else {

        $_SESSION['currentOrg'] = $newOrg;
        header("location: ".WEB_URL);

    }


}
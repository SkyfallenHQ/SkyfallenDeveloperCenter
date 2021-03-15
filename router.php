<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file is handles all url requests and redirects them.               */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("SDC_ABSPATH") or die("Don't mess!");

// Start routing all urls

include_once SDC_ABSPATH."/views/login_view.php";
SDC_Router::routePage("accounts/login","render_login");
SDC_Router::routePage("logout","do_logout", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/home.php";
SDC_Router::routePage("/","render_dev_home", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/docs.php";
SDC_Router::routePage("docs","render_dev_docs", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/profile.php";
SDC_Router::routePage("profile","render_dev_profile", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/org_profile.php";
SDC_Router::routePage("organisations/profile","render_org_profile_page", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/apps.php";
SDC_Router::routePage("apps","render_dev_apps", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/create_org.php";
SDC_Router::routePage("organisations/new","render_org_profile", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/org_members.php";
SDC_Router::routePage("organisations/members","render_org_members", true,"redirect_to_login");

include_once SDC_ABSPATH."/views/org_switch.php";
SDC_Router::routePrefix("organisations/switch","render_org_switch", true,true,"redirect_to_login");

include_once SDC_ABSPATH."/views/id_login.php";
SDC_Router::routePage("developerid","do_oauth_init");
SDC_Router::routePage("developerid/callback","handle_oauth_callback");

include_once SDC_ABSPATH."/views/svc_notavailable.php";
include_once SDC_ABSPATH."/views/tamako_api.php";
include_once SDC_ABSPATH."/views/apphome.php";
SDC_Router::routePrefix("apps/manage","render_app_page", true,true,"redirect_to_login");

// If nothing was routed, display 404
if(!defined("ROUTED")){

    // Include the 404 Page.
    include_once SDC_ABSPATH."/SDC_Includes/404.php";

}

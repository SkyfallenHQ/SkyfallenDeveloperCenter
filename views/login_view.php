<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*           This file contains the function to render login page                  */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die();

/**
 * Renders the login page.
 */

function render_login(){

    if(ISLOGGEDIN){
        header("Location: ".WEB_URL);
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Skyfallen Developer Center - Login with Developer ID</title>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/login.css") ?>">
        <script>
            console.log("Skyfallen always needs cool developers");
            console.log("Volunteer at Skyfallen https://thesf.me/volunteer")
        </script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    </head>
    <body>
    <div class="center-wrapper">
    </div>
    <div class="vertical-center">
        <div class="real-middle">
            <div class="middlewrap">
                <p class="sdc-branding">
                    Welcome to SDC
                    <span class="beta-span-branding">BETA</span>
                </p>
                <a class="button" href="<?php the_pageurl("developerid"); ?>">
                    Login with Skyfallen ID
                </a>
                <a class="button" href="https://developers.theskyfallen.com">
                    Skyfallen Developers
                </a>
                <a class="button" href="https://help.theskyfallen.com">
                    Get Help
                </a>
                <p class="copyright-notif">
                    Skyfallen Developer Center <br> Designed and developed by Skyfallen
                </p>
            </div>
        </div>

    </div>
    </body>
    </html>

    <?php
}

/**
 * Logs a user out
 */
function do_logout(){

    $_SESSION['loginStatus'] = false;
    $_SESSION['user'] = null;
    header("Location: ".WEB_URL."accounts/login");

}

/**
 * Redirects a user to login
 */
function redirect_to_login(){

    header("Location: ".WEB_URL."accounts/login");

}
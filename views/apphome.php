<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*           This file contains the function to render an app's page                */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'App Home' page
 */
function render_app_page($app){

    $urlm = explode( "/",$app);
    if(SDCApp::idExists($urlm[0])){

        $app = new SDCApp($urlm[0]);
        if($app->obj->ownerorg = $_SESSION['currentOrg']->obj->orgid){

            if(count($urlm) == 2 or (count($urlm) == 3 and $urlm[2] == "")){
                switch ($urlm[1]){
                    case "app-center":
                    case "app-center/":
                        render_svc_not_available("App Center");
                        die();
                        break;
                    case "tamako-api":
                    case "tamako-api/":
                    render_tamako_app_page($urlm[0]);
                        die();
                        break;
                    case "updates-console":
                    case "updates-console/":
                    render_svc_not_available("Updates Console");
                        die();
                        break;
                    case "skyfallen-id":
                    case "skyfallen-id/":
                    render_svc_not_available("Skyfallen ID");
                        die();
                        break;
                    default:
                        include_once SDC_ABSPATH."/SDC_Includes/404.php";
                        die();
                        break;

                }
            } elseif(count($urlm) == 1){
                $foo = "bar";
            }else {
                include_once SDC_ABSPATH."/SDC_Includes/404.php";
                die();
            }

        } else {

            include_once SDC_ABSPATH."/SDC_Includes/404.php";
            die();

        }

    } else {

        include_once SDC_ABSPATH."/SDC_Includes/404.php";
        die();

    }

    ?>
    <html>
    <head>
        <title>Skyfallen Developer Center</title>
        <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/app-home.css"); ?>">
        <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/greeting.js"); ?>"></script>
    </head>
    <body>
    <?php

    include SDC_ABSPATH."/partials/app-side-menu.php";
    ?>

    <div class="content" id="content" style="margin-left: 300px;">
        <?php
        include SDC_ABSPATH."/partials/app-top-menu.php";
        ?>
        <div class="welcome-msg">
            <p class="welcome-msg-left" id="greeting">Hi Yiğit Kerem,</p><p class="welcome-msg-desc">Welcome to all-new Skyfallen Developer Center. Here you can manage your app, provision services and get tokens.</p>
            <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
        </div>

        <div class="centered-svc">
            <p><svg style="display: inline; position: relative; top: 7px;" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>Select a service from the menu to start.</p>
        </div>

    </div>
    </body>
    </html>
<?php }
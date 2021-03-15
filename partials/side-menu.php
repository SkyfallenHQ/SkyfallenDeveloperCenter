<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                      This file contains the sidebar                             */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
?>

<div class="side-menu-body" id="side-menu">
    <div class="close-sidebar-wrap"><span class="close-sidebar" onclick="closeNav()">X</span></div>
    <div class="sdc-menubar-title">
        <button onclick="openPage('<?php the_weburl(); ?>')" class="sdc-menubar-title-text">
        Skyfallen <br>
        Developer Center
        </button>
    </div>
    <div class="side-menu-wrapper">
        <ul class="side-menu">
            <li>
                <?php
                    if($_SESSION['currentOrg']->obj->orgtype == "ORGANISATION"){

                        ?>

                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>apps')"><?php echo $_SESSION['currentOrg']->obj->orgname ?>'s Apps</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>docs')">Developer Docs</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>profile')">My Profile</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>organisations/profile')">Organisation Profile</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>organisations/members')">Team Members</button>

                        <?php

                    } else {

                        ?>

                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>apps')">My Apps</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>docs')">Developer Docs</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>profile')">My Profile</button>
                        <button class="side-menu-btn" onclick="openPage('<?php the_weburl(); ?>license')">License Agreement</button>

                        <?php

                    }
                ?>
            </li>
        </ul>
    </div>
</div>
<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                  This file contains the sidebar for apps                         */
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
                <button class="side-menu-btn" onclick="openPage('<?php echo WEB_URL."apps/manage/".$urlm[0]; ?>/updates-console')">Updates Console</button>
                <button class="side-menu-btn" onclick="openPage('<?php echo WEB_URL."apps/manage/".$urlm[0]; ?>/app-center')">App Center</button>
                <button class="side-menu-btn" onclick="openPage('<?php echo WEB_URL."apps/manage/".$urlm[0]; ?>/skyfallen-id')">Skyfallen ID</button>
                <button class="side-menu-btn" onclick="openPage('<?php echo WEB_URL."apps/manage/".$urlm[0]; ?>/tamako-api')">Tamako API</button>
            </li>
        </ul>
    </div>
</div>
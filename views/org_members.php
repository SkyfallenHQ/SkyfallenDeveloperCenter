<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file contains the function to render org members page               */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Org Members' page
 */
function render_org_members(){
    ?>
    <html>
    <head>
        <title>Skyfallen Developer Center</title>
        <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
        <script>
            const WEB_URL = "<?php echo WEB_URL; ?>";
        </script>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/org-members.css"); ?>">
        <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/greeting.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/org-members.js"); ?>"></script>
    </head>
    <body>
    <?php

    $csrf = new SDC_CSRF();

    $message = "Manage your organisations members here.";

    if(!empty($_POST) && SDC_CSRF::verifyCSRF()){

        SDC_CSRF::invalidateCurrentCSRF();

        if(isset($_POST['deluser'])){

            if(SDCUser::userExists($_POST['deluser']) && $_SESSION['currentOrg']->getMemberRole($_SESSION['user']) == "Admin" && $_SESSION['user']->obj->username != $_POST['deluser']){

                $u = new SDCUser($_POST['deluser']);
                $_SESSION['currentOrg']->removeMember($u);
                $message = "Your app was successfully deleted.";

            }else {

                $message = "You don't have the necessary permissions.";

            }

        } else {

            if ($_SESSION['currentOrg']->obj->orgstatus == "ACTIVE") {
                if (validatePostData(['member-name','member-role'])) {

                    try{
                        $tUN = new SDCUser($_POST['member-name']);
                        $_SESSION['currentOrg']->addMember($tUN,$_SESSION['user'],$_POST['member-role']);
                        $message = "User was successfully added";
                    } catch (Exception $e){
                        $message = "There is no such user";
                    }

                } else {
                    $message = "You need to fill out all the fields";
                }
            } else {

                $message = "Your account isn't activated yet.";

            }
        }

    }

    $members = $_SESSION['currentOrg']->listMembers();

    include SDC_ABSPATH."/partials/side-menu.php";
    ?>

    <div class="content" id="content" style="margin-left: 300px;">
        <?php
        include SDC_ABSPATH."/partials/top-menu.php";
        ?>
        <div class="welcome-msg">
            <p class="welcome-msg-left" id="greeting">Hi <?php
                if($_SESSION['user']->safeParseProfile('name') != ""){
                    echo $_SESSION['user']->safeParseProfile('name');
                } else {
                    echo $_SESSION['user']->obj->username;
                }
                ?>,</p><p class="welcome-msg-desc">Welcome to all-new Skyfallen Developer Center. Here you can find your apps
                API Tokens, Developer Docs and your Developer Profile.</p>
            <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
        </div>

        <div class="member-box">
            <div class="member-box-headline">
                <p>Organisation Members - <?php echo $message; ?></p>

                <div onclick="triggerNewMemberFunction()" class="btn-div"><svg style="height: 25px; width: 25px; position: absolute; top: 15px; right:60px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
            </div>

            <?php

            foreach ($members as $member){

                ?>

                <div class="member-item" style="margin-top: 70px; cursor: pointer;">
                    <p class="member-item-name"><?php
                        $tU = new SDCUser(SDCUser::getUsernameFromID($member));
                        echo $tU->safeParseProfile('name');
                        ?></p>
                    <form method="post">
                        <?php $csrf->put(); ?>
                        <input name="deluser" value="<?php echo $tU->obj->username;?>" hidden>
                        <button type="submit" class="member-del-btn"><svg style="height: 25px; width: 25px;"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                    </form>
                    <!--svg style="height: 25px; width: 25px; position: absolute; top: 22px; right:60px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg-->
                </div>

                <?php

            }

            ?>

            <div class="new-form" id="create-new-member-form" style="display: none;">
                <form method="post">
                    <?php $csrf->put(); ?>
                    <label for="member-name">New Member's Username:</label>
                    <input class="a-input" id="member-name" name="member-name">
                    <label for="member-role">Role</label>
                    <select class="a-input" id="member-role" name="member-role" style="width: 200px;">
                        <option>Admin</option>
                        <option>Member</option>
                    </select>
                    <button type="submit" class="a-input" style="width: 250px; margin-top: 20px;">Add User</button>
                </form>
            </div>

        </div>

    </div>
    </body>
    </html>
<?php }
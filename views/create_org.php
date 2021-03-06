<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file contains the function to render the create org page            */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'New Org' page
 */
function render_org_profile(){


    $countries = array("","Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
    $types = array("","For Profit","Non-Profit");


    $csrf = new SDC_CSRF();

    $message = "Create an organisation for your account.";

    $irs = "";

    if($_SESSION['user']->obj->accountstatus == "IN_REVIEW"){
        $irs = "disabled";
    }

    if(!empty($_POST) && SDC_CSRF::verifyCSRF()){

        SDC_CSRF::invalidateCurrentCSRF();
        if(validatePostData(['org-name','org-rname','org-email','org-ctype','org-country','org-rd'])){
            $org = SDCOrganisation::createTeam($_SESSION['user']->obj->username,$_POST['org-rd'],$_POST['org-name']);
            $org->saveMeta('org_rname',$_POST['org-rname']);
            if(isset($_POST['org-vn'])){
                $org->saveMeta('org_vn',$_POST['org-vn']);
            }
            $org->saveMeta('org_email',$_POST['org-email']);
            $org->saveMeta('org_ctype',$_POST['org-ctype']);
            $org->saveMeta('org_country',$_POST['org-country']);
            $org->addMember($_SESSION['user'],$_SESSION['user']);
            $message = "Your account was successfully sent for validation. You may not edit it before validation is complete.";
        } else {
            $message = "Your profile must be completed before sending for validation.";
        }

    }

    ?>
    <html>
    <head>
        <title>Skyfallen Developer Center</title>
        <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.js"); ?>"></script>
        <script>
            const WEB_URL = "<?php echo WEB_URL; ?>";
        </script>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/profile.css"); ?>">
        <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
    </head>
    <body>
    <?php
    include SDC_ABSPATH."/partials/side-menu.php";
    ?>

    <div class="content" id="content" style="margin-left: 300px;">
        <?php
        include SDC_ABSPATH."/partials/top-menu.php";
        ?>
        <div class="welcome-msg">
            <p class="welcome-msg-left">Skyfallen Developer Organisation</p>
            <p class="welcome-msg-left" style="font-size: 13px;"><?php echo $message; ?></p>
            <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
            <form method="post">
                <?php
                $csrf->put();
                ?>
                <div class="profile-wrap">
                    <div class="profile-col">
                        <label for="org-name">Name of the Organisation:</label>
                        <input class="profile-input" id="org-name" name="org-name" >
                        <label for="org-rname">Official Full Name of the Company:</label>
                        <input class="profile-input" id="user-rname" name="org-rname">
                        <label for="org-vn">IRS/EIN/VAT Number (optional):</label>
                        <input class="profile-input" id="org-vn" name="org-vn">
                        <label for="org-email">Company Contact Email:</label>
                        <input class="profile-input" id="org-email" name="org-email">
                    </div>
                    <div class="profile-col" id="profile-rcol">
                        <label for="org-country">Company Country:</label>
                        <select class="profile-input" id="org-country" name="org-country">
                            <?php

                            $userCountry = $_SESSION['user']->safeParseProfile('country');

                            foreach ($countries as $country){

                                $selected = "";

                                if($userCountry == $country){

                                    $selected = "selected";

                                }

                                echo "<option value='".$country."' ".$selected.">".$country."</option>";

                            }

                            ?>
                        </select>
                        <label for="org-ctype">Company Type:</label>
                        <select class="profile-input" id="org-ctype" name="org-ctype" <?php echo $irs ?>>
                            <?php

                            $userJob = $_SESSION['user']->safeParseProfile('job');

                            foreach ($types as $uj){

                                $selected = "";

                                if($userJob == $uj){

                                    $selected = "selected";

                                }

                                echo "<option value='".$uj."' ".$selected.">".$uj."</option>";

                            }

                            ?>
                        </select>
                        <label for="org-rd">Organisation Reverse Domain:</label>
                        <input class="profile-input" id="org-rd" name="org-rd" placeholder="eg. com.domain.sub for sub.domain.com">
                        <label id="account-status">Account Status: <?php echo $_SESSION['user']->getNiceAccountState(); ?></label>
                        <button type="submit" class="profile-input" style="width: 250px;">Save and Submit for Validation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </body>
    </html>
<?php }

#!/usr/local/bin/php

<?php

/*
    zadanie cron
    * /1 * * * * cd /home/qotsa2/domains/zygadlo.org/public_html/cms/cron; newsletter.php

*/



    ob_start();
    ini_set("display_errors","on");

    chdir("../");

    //begin config files
    include "system.config.php";
    include "config/smtp.config.php";
    include "config/db.config.php";
    include "config/url.config.php";
    //end config files

    include "libs/bootstrap.php";
    include "libs/database.php";
    include "libs/base.php";
    include "libs/ctrl.php";
    include "libs/view.php";
    include "libs/model.php";
    include "libs/email.php";
    include "libs/myexception.php";
    include "libs/validator.php";
    include "libs/settings.php";
    include "libs/column.php";
    include "libs/session.php";
    require "libs_other/PHPMailer/PHPMailerAutoload.php";

    include "ctrls/newsletterCtrl.php";

    $ptr = new newsletterCtrl();
    //$ptr->Test();
    $ptr->Send();


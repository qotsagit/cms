#!/usr/local/bin/php

<?php


    ob_start();
    ini_set("display_errors","on");

    //begin config files
    include "system.config.php";
    //include "config/smtp.config.php";
    include "config/db.config.php";
    //include "config/url.config.php";
    //end config files

    include "libs/database.php";
    include "libs/base.php";
    include "libs/model.php";
    include "libs/myexception.php";
    //include "libs/validator.php";
    //include "libs/settings.php";
    //include "libs/column.php";
    //include "libs/session.php";


    include "libs/alter.php";

    $ptr = new Alter();
    $ptr->Update();


?>
#!/usr/local/bin/php

<?php


    ob_start();
    ini_set("display_errors","on");

    //begin config files
    include "system.config.php";
    include "config/db.config.php";
    //end config files

    include "libs/database.php";
    include "libs/base.php";
    include "libs/model.php";
    include "libs/myexception.php";

    include "libs/cleaner.php";

    $ptr = new Cleaner();
    $prt->Run();


?>
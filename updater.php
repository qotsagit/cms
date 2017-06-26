#!/usr/local/bin/php

<?php


    ob_start();
    ini_set("display_errors","on");

    //begin config files
    include "system.config.php";
    include "config/db.config.php";
    //end config files

    include "libs/http.php";

    $ptr = new Http();
    $ptr->Init();
    $ptr->Download("http://cms.zygadlo.org/update.cms.tar.gz");


?>
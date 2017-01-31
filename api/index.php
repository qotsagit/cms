<?php

    ob_start();
    session_start();
    session_name("page");
    ini_set("display_errors","on");
    error_reporting(E_ALL);

    include "../config.php";
    include "../libs/bootstrap.php";
    include "../libs/database.php";
    include "../libs/base.php";
    include "../libs/input.php";
    include "../libs/ctrl.php";
    include "../libs/view.php";
    include "../libs/model.php";
    include "../libs/email.php";
    include "../libs/myexception.php";
    include "../libs/validator.php";
    include "../libs/settings.php";
    include "../libs/column.php";
    include "../libs/session.php";

    $start = microtime();
    $app = new Bootstrap();
    $app->Ctrl = CTRL_HOME;
    $app->DefaultCtrl = CTRL_HOME;
    $app->Run();

    if(DEBUG)
    {
        $time = microtime() - $start;
        $app->RenderTime = $time;
        $app->ShowDebug();
    }

?>
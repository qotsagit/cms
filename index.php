<?php

    define('RENDER_DEBUG',false);
    define('RENDER_NAVBAR',true);
    define('RENDER_FOOTER',true);
    define('TECHNICAL_BREAK',false);

    //Style
    define('STYLE','default');
    define('BASE_HREF','/');
    //file templates
    define('TEMPLATE_FOLDER','style/'.STYLE.'/templates');
    define('TEMPLATE_HEADER_FILE','style/'.STYLE.'/header.html');
    define('TEMPLATE_FOOTER_FILE','style/'.STYLE.'/footer.html');
    define('DEFAULT_AVATAR','avatar.png');
    define('DEFAULT_IMAGE','nophoto.png');
    define('AVATAR_DIR','filemanager/files/avatar');
    define('IMAGE_DIR','filemanager/files/images');


    ob_start();
    ini_set("display_errors","on");
    session_name('page');
    session_start();
    error_reporting(E_ALL);

    // begin config files
    include "system.config.php";
    include "config/smtp.config.php";
    include "config/db.config.php";
    include "config/url.config.php";
    // end config files

    include "libs/bootstrap.php";
    include "libs/database.php";
    include "libs/base.php";
    include "libs/input.php";
    include "libs/ctrl.php";
    include "libs/view.php";
    include "libs/model.php";
    include "libs/email.php";
    include "libs/myexception.php";
    include "libs/validator.php";
    include "libs/settings.php";
    include "libs/column.php";
    include "libs/session.php";
    require 'libs_other/PHPMailer/PHPMailerAutoload.php';

    $start = microtime();
    $app = new Bootstrap();
    $app->Ctrl = CTRL_PAGE;         //z tego ctrl startuj
    $app->DefaultCtrl = CTRL_PAGE;  //ten kontroller będzie załadowany jak nie będzie istniał kontroller z url
    $app->Run();

    if(RENDER_DEBUG)
    {
        $time = microtime() - $start;
        $app->RenderTime = $time;
        $app->ShowDebug();
    }

?>

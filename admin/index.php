<?php

    define('DEBUG',true);
    //Admin Style
    define('STYLE','default');
    define('BASE_HREF','/admin/');
    //file templates
    define('PAGE_TEMPLATE_FOLDER','../style/default/templates');	//styl dla głównej strony do modelu file
    define('TEMPLATE_FOLDER','style/'.STYLE.'/templates');
    define('TEMPLATE_HEADER_FILE','style/'.STYLE.'/header.html');
    define('TEMPLATE_FOOTER_FILE','style/'.STYLE.'/footer.html');

    define('DEFAULT_AVATAR','avatar.png');
    define('DEFAULT_IMAGE','nophoto.png');
    define('AVATAR_DIR','../filemanager/files/avatar');
    define('IMAGE_DIR','../filemanager/files/images');

    ob_start();
    session_start();
    session_name('admin');
    ini_set("display_errors","on");
    error_reporting(E_ALL);
   
    include "../system.config.php";
    include "../config/smtp.config.php";
    include "../config/db.config.php";
    include "../config/url.config.php";
      
    include "../libs/bootstrap.php";
    include "../libs/database.php";
    include "../libs/base.php";
    include "../libs/input.php";
    include "../libs/ctrl.php";
    include "../libs/view.php";
    include "../libs/model.php";
    include "../libs/filemodel.php";
    include "../libs/email.php";
    include "../libs/myexception.php";
    include "../libs/validator.php";
    include "../libs/settings.php";
    include "../libs/column.php";
    include "../libs/session.php";
    include "../libs/image.php";
    include "../libs_other/PHPMailer/PHPMailerAutoload.php";

    $start = microtime();
    $app = new Bootstrap();
    $app->Ctrl = CTRL_HOME;
    //$app->DefaultCtrl = CTRL_CALENDAR;
    $app->Run();

    if(DEBUG)
    {
        $time = microtime() - $start;
        $app->RenderTime = $time;
        $app->ShowDebug();
    }

?>
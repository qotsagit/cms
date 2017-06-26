<?php

/**
 * Bootstrap
 * 
 * @category   Libs
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class Bootstrap
{
    public $Ctrl;
    public $DefaultCtrl;
    public $Method;
    public $Params;
    public $Page;
    public $RenderTime;
    public $CtrlClass;

    public function __construct()
    {
        $this->Ctrl = DEFAULT_CTRL;
        $this->DefaultCtrl = DEFAULT_CTRL;
    }

    public function Run()
    {
       if ($this->CSRF(false))
        {
            $this->ReadGet();
            $this->ReadPost();
            $this->CheckRight();
            $this->CheckCtrl();
            $this->SetData();
            $this->LoadController();
        }
        else
        {
            print 'CSRF';
        }

    } 

    private function CSRF($csrf)
    {
        if ($csrf)
        {
            print $key = sha1(microtime());
            $_SESSION['csrf'] = $key;

            if (empty($_SESSION['csrf']))
                return false;
            if (empty($_REQUEST['csrf']))
                return false;
            if ($_SESSION['csrf'] != $_REQUEST['csrf'])
                return false;

            return true;
        }
        else
        {
            return true;
        }
    }

    private function ReadGet()
    {
        // parse z URL
        if(isset($_GET[URL]))
        {
             @list($this->Ctrl, $this->Method, $this->Params) = explode("/", $_GET[URL], 3);
             @list($this->Page) = explode("/", $_GET[URL], 3);
        }

    }

    private function ReadPost()
    {    
        // parent strony przy zmianie przeskakuje do danego foldera
        if (isset($_REQUEST[IDPARENT]))     { Session::SetIdParent($_REQUEST[IDPARENT]); }
        
        //zaznaczone rekordy
        if (isset($_REQUEST[IDSELECTED]))   {  print_r($_REQUEST[IDSELECTED]);   }
         
        if (!empty($_REQUEST[METHOD]))      { $this->Method = $_REQUEST[METHOD];  }
    }
    
    // na razie w fazie rozwoju
    // trzeba sprawdzać czy w url to jest CTRL czy strona
    private function CheckRight()
    {
        //new myException('NO RIGHT FOR ACTION',$this->Ctrl.'<br>'.$this->Method);
        //print $this->Ctrl.'<br>'.$this->Method;
    }
    
    private function SetData()
    {

        if (Session::GetCtrl() != $this->Ctrl)
        { 
            Session::SetDefault();
        }
        
       Session::SetCtrl($this->Ctrl);
    }
    
    private function CheckCtrl()
    {
        $filename = CTRL_FOLDER . '/'. $this->Ctrl . 'Ctrl.php';

        // nie ma pliku controlera przełącz na defaultowy ctrl
        // a defaultowy controller w page niech otwiera strony z bazy danych
        
        if (file_exists($filename) == false)
        {
            //$this->Page = $this->Ctrl;                      // w page jest teraz strona aktualna
            $this->Ctrl = $this->DefaultCtrl;               // a kontroller jest defaultowy
            $filename = CTRL_FOLDER . '/'. $this->Ctrl . 'Ctrl.php';
        }

        if (file_exists($filename) == false)
        {
            $this->LoadErrorController($filename);
        }

    }
    
    private function LoadController()
    {   
        include CTRL_FOLDER . '/' . $this->Ctrl . 'Ctrl.php';
        $classname = $this->Ctrl.'Ctrl';
        $this->CtrlClass = new $classname;
        $this->CtrlClass->Ctrl = $this->Ctrl;
        $this->CtrlClass->DefaultCtrl = $this->DefaultCtrl;
        $this->CtrlClass->Method = $this->Method;
        $this->CtrlClass->Params = $this->Params;
        $this->CtrlClass->Page = $this->Page;
        $this->CtrlClass->Init();
        
        //if(empty($this->CtrlClass->Method))
        //{
          //  $this->CtrlClass->Method = DEFAULT_METHOD;
        //}
        
        // nie wymaga logowania
        if ($this->CtrlClass->NeedAuth == false)
        {
            $this->CtrlClass->Load();
            return true; 
        }
        
        // typ użytkownika USER ten tym może dostęp mieć do panelu administratora
        // controlery w admin powinny mieć ustawiony ten typ controlera
        if (Session::GetValidUser())
        {
            $this->CtrlClass->Load();
            return true;
        }
          
        $this->LoadLoginController();
        
    }

    private function LoadLoginController()
    {
        include CTRL_FOLDER . '/loginCtrl.php';
        $class = new loginCtrl();
        $class->Type = $this->CtrlClass->NeedAuth;
        $class->Load();
    }

    private function LoadErrorController($filename)
    {
        new myException('404 Not Found',$filename);
    }

    public function ShowJSON()
    {
        $data = json_decode(file_get_contents("php://input"));
        printf("DATA: %s", var_export($data, true));
        //$usrname = mysql_real_escape_string($data->uname);
        //$upswd = mysql_real_escape_string($data->pswd);
        //$uemail = mysql_real_escape_string($data->email);
    }

    public function ShowDebug()
    {
        print '<div class="alert alert-danger">';
        print "Debug<br>";
        print "Page: [" . $this->Page . "]<br>";
        print "Controller: [" . $this->Ctrl . "]<br>";
        print "Method: [" . $this->Method . "]<br>";
        print "Params: [" . var_export($this->Params,true) . "]<br>";
        printf("GET: %s<br>", var_export($_GET, true));

        printf("POST: %s<br>", var_export($_POST, true));
        printf("FILES: %s<br>", var_export($_FILES, true));
        printf("REQUEST: %s<br>", var_export($_REQUEST, true));
        printf("SESSION: %s<br>", var_export($_SESSION, true));
        printf("COOKIE: %s<br>", var_export($_COOKIE, true));
        //printf("SERVER: %s<br>", var_export($_SERVER, true));
        print '</div>';
        print '<div class="alert alert-warning">Render time: ' . $this->RenderTime . '</div>';
    }

}

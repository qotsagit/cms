<?php

/**
 * loginCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'views/loginView.php';

class jsonCtrl extends Ctrl
{
    
    public function __construct()
    {
        parent::__construct(false);
        $this->View = new loginView($this);       
        $this->Init();
    }
       
    public function Method()
    {
        $this->Index();
    }   
        
    private function Read()
    {
        //print 'read from login';
        //$this->Email = filter_input(INPUT_POST, LOGIN_EMAIL);
        //$this->RememberMe = filter_input(INPUT_POST, LOGIN_REMEMBER_ME);
    }
    
    public function Index()
    {
            $msg = array
            (
                'title'  => 0,
                'text'  => '<div class="alert alert-danger">'.$this->Msg('_EMAIL_NOT_VALID_','Email Not Valid').'</div>'
            );

        print json_encode($msg);
    }

	
}
    



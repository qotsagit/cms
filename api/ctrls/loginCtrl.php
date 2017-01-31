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


class loginCtrl extends Ctrl
{
    
    public function __construct()
    {
        parent::__construct(false);

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
        //$this->Read();
        if(Session::GetValidUser())
        {    
	    print 'valid user';
        
        }else{    
        
	    print 'login';
        
        }
    }
    
}


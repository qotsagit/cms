<?php

class loginView extends View
{
    
    public $RememberMe;
        
    public function __construct()
    {
        parent::__construct();
    }
    
    public function renderConfirmError()
    {
        
        
    }
    public function renderLoginError()
    {
        if ($this->LoginError)
        {
            print "<div class='alert alert-danger' role='alert'>" .$this->Msg('_LOGIN_ERROR_','Login Error') . "</div>";
        }
    }

}


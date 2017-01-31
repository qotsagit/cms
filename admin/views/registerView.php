<?php

class registerView extends View
{
    
    public $EmailError;
    public $Controller;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function renderLoginError()
    {
        if ($this->Controller->LoginError)
        {
            print "<div class='alert alert-danger' role='alert'>" . _LOGIN_ERROR_ . "</div>";
        }
    }

    public function renderRegisterError()
    {
        if($this->Controller->Status == EMAIL_EXISTS)
        {
             print "<div class='alert alert-danger' role='alert'>"._EMAIL_EXISTS_."</div>";
        }
        
        if($this->Controller->Status == EMAIL_NOT_VALID)
        {
             print "<div class='alert alert-danger' role='alert'>"._EMAIL_NOT_VALID_."</div>";
        }
    }
    
}


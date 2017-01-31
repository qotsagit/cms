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

}


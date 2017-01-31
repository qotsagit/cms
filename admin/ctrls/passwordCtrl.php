<?php

/**
 * passwordCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'views/passwordView.php';
include 'models/userModel.php';

class passwordCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        $this->View = new passwordView($this);
        $this->Model = new userModel();
        $this->Validator = new Validator();           
        
        $this->InitFormFields();
        $this->InitFields();
        $this->InitValidatorFields();
    }

    public function Method()
    {
        switch($this->Method)
        {
            case METHOD_SAVE: $this->Save();
                break;
            default : $this->Index();
                break;
        }
    
    }
    
    private function InitFormFields()
    {
        $this->View->Password = new Input();
        $this->View->RepeatPassword = new Input();
    }

    private function InitFields()
    {
        //required
        $this->View->Password->SetRequired(true);
        $this->View->RepeatPassword->SetRequired(true);
        
        // match
        $this->View->Password->SetMatch($this->View->RepeatPassword);
        $this->View->RepeatPassword->SetMatch($this->View->Password);
        
        //min length
        $this->View->Password->SetMinLength(8);
        $this->View->RepeatPassword->SetMinLength(8);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Password);
        $this->Validator->Add($this->View->RepeatPassword);
    }
    
    private function ReadForm()
    {
        $this->View->Password->Value = filter_input(INPUT_POST, PASSWORD);        
        $this->View->RepeatPassword->Value = filter_input(INPUT_POST, REPEAT_PASSWORD);
    }
   
    public function Save()
    {
        $this->ReadForm();
        if ($this->Validate())
        {
            $this->Update();
            $this->Index(true);
        }
        else
        {
            $this->Index();
        }
    }
    
    private function Update()
    {
        $this->Model->password = $this->View->Password->Value;
        $this->Model->id_user = Session::GetUser()->id_user;
        $this->Model->UpdatePassword();
    }
    
    public function Index($changed = false)
    {
        //if($changed)

        $this->View->Render('password/index');
    }

}

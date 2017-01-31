<?php

/**
 * registerCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/registerModel.php';
include 'views/registerView.php';

class registerCtrl extends Ctrl
{

    public $Email;    
    public $Password;
    public $Status;

    public function __construct()
    {
        parent::__construct(false);
                
        $this->Model = new RegisterModel();
        $this->View = new RegisterView($this);
        
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }
   
    private function InitFormFields()
    {
        $this->View->Email = new Input();
        $this->View->Password = new Input();
        $this->View->FirstName = new Input();
        $this->View->LastName = new Input();
        $this->View->City = new Input();
        $this->View->ZipCode = new Input();
        
        $this->View->Newsletter = new Input();
    }
    
    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
        $this->View->Email->SetType(FIELD_TYPE_EMAIL);
        
        $this->View->Password->SetRequired(true);
        $this->View->Password->SetMinLength(8);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
        $this->Validator->Add($this->View->Password);
    }

    public function ReadForm()
    {
        $this->View->Email->Value = filter_input(INPUT_POST, REGISTER_EMAIL);
        $this->View->Password->Value = filter_input(INPUT_POST, REGISTER_PASSWORD);
        $this->View->FirstName->Value = filter_input(INPUT_POST, REGISTER_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, REGISTER_LAST_NAME);
        $this->View->Newsletter->Value = filter_input(INPUT_POST, REGISTER_NEWSLETTER);
    }

    public function Insert()
    {
        $this->Model->email = $this->View->Email->Value;
        $this->Model->password = $this->View->Password->Value;
        $this->Model->newsletter = $this->View->Newsletter->Value;

        $this->Model->Insert();
    }

    public function FormAdd()
    {
        $this->View->Render('register/index');
    }

    public function Listing()
    {
        $this->View->Render('register/index');       
    }


}

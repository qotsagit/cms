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
                
        $this->Model = new registerModel();
        $this->View = new registerView($this);
        
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
        $this->View->Phone = new Input();
        
        $this->View->Newsletter = new Input();
    }
    
    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
        $this->View->Email->SetUniqueEmail();
        $this->View->Email->SetType(FIELD_TYPE_EMAIL);
        $this->View->Password->SetRequired(true);
        $this->View->Password->SetMinLength(8);
        
        $this->View->FirstName->SetRequired(true);
        $this->View->LastName->SetRequired(true);
        $this->View->City->SetRequired(true);

        $this->View->ZipCode->SetRequired(true);
        
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
        $this->Validator->Add($this->View->Password);
        $this->Validator->Add($this->View->FirstName);
        $this->Validator->Add($this->View->LastName);
        $this->Validator->Add($this->View->City);
        $this->Validator->Add($this->View->ZipCode);
    }

    public function ReadForm()
    {
        $this->View->Email->Value = filter_input(INPUT_POST, REGISTER_EMAIL);
        $this->View->Password->Value = filter_input(INPUT_POST, REGISTER_PASSWORD);
        $this->View->FirstName->Value = filter_input(INPUT_POST, REGISTER_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, REGISTER_LAST_NAME);
        $this->View->City->Value = filter_input(INPUT_POST, REGISTER_CITY);
        $this->View->ZipCode->Value = filter_input(INPUT_POST, REGISTER_ZIP_CODE);
        $this->View->Newsletter->Value = filter_input(INPUT_POST, REGISTER_NEWSLETTER);
        $this->View->Phone->Value = filter_input(INPUT_POST, REGISTER_PHONE);
        
    }

    public function Insert()
    {
        $this->Model->id_lang = DEFAULT_LANG_ID;
        $this->Model->id_role = DEFAULT_ROLE_ID;
        $this->Model->email = $this->View->Email->Value;
        $this->Model->password = $this->View->Password->Value;
        $this->Model->first_name = $this->View->FirstName->Value;
        $this->Model->last_name = $this->View->LastName->Value;
        $this->Model->city = $this->View->City->Value;
        $this->Model->zip_code = $this->View->ZipCode->Value;
        $this->Model->phone = $this->View->Phone->Value;
        $this->Model->newsletter = $this->View->Newsletter->Value;
        $this->Model->type = USER_TYPE_CUSTOMER;
        $this->Model->active = STATUS_ACTIVE;
        $this->Model->avatar = DEFAULT_AVATAR;
        
        
        $this->Model->random = $this->RandomString(255);
        $this->Model->Insert();
        
        
        // send register email
        $email->Send($this->View->email, $this->View->Subject->Value,$msg);
        
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

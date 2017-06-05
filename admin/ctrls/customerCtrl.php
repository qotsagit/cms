<?php

include 'models/customerModel.php';
include 'views/customerView.php';

//pola formularza
define('CUSTOMER_IDCUSTOMER','id');
define('CUSTOMER_NAME','name');
define('CUSTOMER_ADDRESS','address');
define('CUSTOMER_WEBSITE','website');
define('CUSTOMER_EMAIL','email');
define('CUSTOMER_CITY','city');
define('CUSTOMER_PHONE','phone');
define('CUSTOMER_TEXT','text');

class customerCtrl extends Ctrl
{
    
    public function __construct()
    {
        parent::__construct();
        $this->Model = new customerModel(); 
        $this->View = new customerView($this);
        $this->InitFormFields();
    }
    
    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdCustomer = new Input();
        $this->View->Name = new Input();
        $this->View->Address = new Input();
        $this->View->Website = new Input();
        $this->View->Email = new Input();
        $this->View->City = new Input();
        $this->View->Phone = new Input();
        $this->View->Text = new Input();
        
        $this->View->Id->Value = 0;
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->Name->Value = filter_input(INPUT_POST, CUSTOMER_NAME);
        $this->View->Address->Value = filter_input(INPUT_POST, CUSTOMER_ADDRESS);
        $this->View->Website->Value = filter_input(INPUT_POST, CUSTOMER_WEBSITE);
        $this->View->Email->Value = filter_input(INPUT_POST, CUSTOMER_EMAIL);
        $this->View->City->Value = filter_input(INPUT_POST, CUSTOMER_CITY);
        $this->View->Phone->Value = filter_input(INPUT_POST, CUSTOMER_PHONE);
        $this->View->Text->Value = filter_input(INPUT_POST, CUSTOMER_TEXT);
    }
    
    public function SetModelValues()
    {
        $this->Model->id_customer = $this->View->Id->Value;
        $this->Model->name = $this->View->Name->Value;
        $this->Model->address = $this->View->Address->Value;
        $this->Model->website = $this->View->Website->Value;
        $this->Model->email = $this->View->Email->Value;
        $this->Model->city = $this->View->City->Value;
        $this->Model->phone = $this->View->Phone->Value;
        $this->Model->text = $this->View->Text->Value;
    }
    
    public function Insert()
    {
        $this->SetModelValues();
        $this->Model->Insert();
    }
    
    public function Update()
    {
        $this->SetModelValues();
        $this->Model->Update();
    }
    
    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_customer;            
            $this->View->Name->Value = htmlspecialchars($item->name);
            $this->View->Address->Value = $item->address;
            $this->View->Website->Value = $item->website;
            $this->View->Email->Value = $item->email;
            $this->View->City->Value = $item->city;
            $this->View->Phone->Value = $item->phone;
            $this->View->Text->Value = $item->text;
            
            return true;
        }

        return false;
    }

    public function FormAdd()
    {
        $this->View->Title = $this->Msg('_NEW_','New') ;
        $this->View->Render('customer/add');
    }

    public function FormEdit()
    {
        $this->View->Title = $this->Msg('_EDIT_','Edit') ;
        if ($this->ReadDatabase())
        {
            $this->View->Render('customer/add');
        
        }else{
        
             new myException('DATABASE ERROR');   
        
        }
    }
    
    
    
    
   
    
   
    
    
   
}

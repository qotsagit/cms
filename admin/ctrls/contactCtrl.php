<?php

include 'models/contactModel.php';
include 'views/contactView.php';

class contactCtrl extends Ctrl
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->Model = new contactModel();
        
        $this->View = new contactView($this);
        $this->View->ViewTitle = $this->Msg('_CONTACTS_','Contacts');
        $this->View->CtrlName = CTRL_CONTACT;

        $this->Validator = new Validator();
        $this->InitFormFields();
   
    }
    
    private function InitFormFields()
    {
        $this->View->Id = new Input();
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        //$this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
        //$this->View->Name->Value = filter_input(INPUT_POST, LANG_NAME);
        //$this->View->Code->Value = filter_input(INPUT_POST, LANG_CODE);
        //$this->View->Active->Value = filter_input(INPUT_POST, LANG_STATUS);
    }
    
    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_contact;            
            //$this->View->IdLang->Value = $item->id_lang;            
            //$this->View->Name->Value = $item->name;
            //$this->View->Code->Value = $item->code;
            //$this->View->Active->Value = $item->active;
            
            return true;
        }

        return false;
    }

    
    
   
    
   
    
    
   
}

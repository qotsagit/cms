<?php

/**
 * settingsCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/userModel.php';
include 'models/langModel.php';
include 'views/settingsView.php';


class profileCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();
                
        $this->View = new settingsView();
        $this->View->ViewTitle = $this->Msg('_SETTINGS_','Settings');
        
        $this->Model = new userModel();        
        
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
        
    }

    private function InitFormFields()
    {
        $this->View->IdUser = new Input();
        $this->View->IdLang = new Input();
        $this->View->Email = new Input();
        $this->View->Nick = new Input();
        $this->View->FirstName = new Input();
        $this->View->LastName = new Input();

    }

    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
        $this->View->Nick->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
        $this->Validator->Add($this->View->Nick);
    }
   
    
    public function ReadForm()
    {
        $this->View->IdUser->Value = filter_input(INPUT_POST, IDUSER);
        $this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
        $this->View->Email->Value = filter_input(INPUT_POST, USER_EMAIL);
        $this->View->FirstName->Value = filter_input(INPUT_POST, USER_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, USER_LAST_NAME);
        $this->View->Nick->Value = filter_input(INPUT_POST, USER_NICK);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get(Session::GetUser()->id_user);

        foreach ($array as $item)
        {
            $this->View->IdUser->Value = $item->id_user;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->Email->Value = $item->email;
            $this->View->FirstName->Value = $item->first_name;
            $this->View->LastName->Value = $item->last_name;
            $this->View->Nick->Value = $item->nick;

            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_user = $this->View->IdUser->Value;
        $this->Model->id_lang = $this->View->IdLang->Value;
        $this->Model->nick = $this->View->Nick->Value;
        $this->Model->email = $this->View->Email->Value;
        $this->Model->first_name = $this->View->FirstName->Value;
        $this->Model->last_name = $this->View->LastName->Value;

        $this->Model->UpdateSettings();
        
        $array = $this->Model->Get($this->View->IdUser->Value);
        
        foreach ($array as $item)
        {
            Session::SetLang($item->id_lang);
            Session::SetUser($item);
        }
    }
    
    public function FormAdd()
    {
        $this->Listing(true);
        
    }

    public function Listing($error = false)
    {
        $items = new langModel();
        $this->View->Languages = $items->All();
        if($error)
        {
             $this->View->Render('profile/add');
        }
        else
        {
            if ($this->ReadDatabase())
                $this->View->Render('profile/add');
            else
                $this->View->Render('error');
        }
    }
    
    public function Index()
    {
        $this->Listing();
    }

}

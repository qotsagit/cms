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

include 'views/settingsView.php';
include 'models/settingsModel.php';
include 'models/langModel.php';
include 'models/pageModel.php';

class settingsCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();
                
        $this->View = new settingsView();
        $this->View->ViewTitle = $this->Msg('_SETTINGS_','Settings');
        
        $this->Model = new settingsModel();        
        
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
        
    }

    private function InitFormFields()
    {
        $this->View->IdPage = new Input();
        $this->View->IdLang = new Input();
        $this->View->Email = new Input();
        $this->View->Url = new Input();
    }

    private function InitRequired()
    {
        //$this->View->Email->SetRequired(true);
        //$this->View->Nick->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        //$this->Validator->Add($this->View->Email);
        //$this->Validator->Add($this->View->Nick);
    }
   
    public function ReadForm()
    {
        $this->View->IdPage->Value = filter_input(INPUT_POST, IDPAGE);
        $this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
        $this->View->Email->Value = filter_input(INPUT_POST, SETTINGS_EMAIL);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get();

        foreach ($array as $item)
        {
            $this->View->IdPage->Value = $item->id_page;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->Email->Value = $item->email;
         
            return true;
        }

        return true;
    }

    public function Insert()
    {
        $this->Model->id_page = $this->View->IdPage->Value;
        
        $item = $this->Model->Exists();
        
        if($item)
        {
            $this->Model->Update();
        }
        else
        {
            $this->Model->Insert();
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

        $items = new pageModel();
        $items->Tree(0,0,Session::GetLang(),$this->View->Pages);
                
        if($error)
        {
            //$this->View->RenderError('błąd walidacji');
             $this->View->Render('settings/add');
        }
        else
        {
            if ($this->ReadDatabase())
                $this->View->Render('settings/add');
            else
                $this->View->Render('error');
        }
    }
    
    public function Index()
    {
        $this->Listing();
    }

}

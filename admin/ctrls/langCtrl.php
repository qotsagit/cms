<?php
/**
 * langCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/langModel.php';
include 'models/activeModel.php';
include 'views/langView.php';

class langCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        $this->Model = new langModel();
        
        $items = new activeModel();   
        
        $this->View = new langView($this);        
        $this->View->ViewTitle = $this->Msg('_LANGUAGES_','Languages');
        $this->View->CtrlName = CTRL_LANG;
        $this->View->Statuses = $items->All();
       
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
        
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdLang = new Input();
        $this->View->Name = new Input();        
        $this->View->Code = new Input();
        $this->View->Active = new Input();
    }

    private function InitRequired()
    {
        $this->View->Name->SetRequired(true);
        $this->View->Name->SetMaxLength(24);
        $this->View->Code->SetRequired(true);
        $this->View->Code->SetMaxLength(2);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Name);
        $this->Validator->Add($this->View->Code);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdLang->Value = filter_input(INPUT_POST, LANG_ID);
        $this->View->Name->Value = filter_input(INPUT_POST, LANG_NAME);
        $this->View->Code->Value = filter_input(INPUT_POST, LANG_CODE);
        $this->View->Active->Value = filter_input(INPUT_POST, LANG_STATUS);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_lang;            
            $this->View->IdLang->Value = $item->id_lang;            
            $this->View->Name->Value = $item->name;
            $this->View->Code->Value = $item->code;
            $this->View->Active->Value = $item->active;
            
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_lang = $this->View->IdLang->Value;
        $this->Model->name = $this->View->Name->Value;
        $this->Model->code = $this->View->Code->Value;
        $this->Model->active = $this->View->Active->Value;
        
        if ($this->View->IdLang->Value > 0)
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
        $this->View->Render('lang/add');
    }

    public function FormEdit()
    {
        if ($this->ReadDatabase($this->View->Id))
        {
            $this->View->Render('lang/add');
        
        }else{
            
            new myException('DATABASE READ ERROR');
            
        }
    }
    
}

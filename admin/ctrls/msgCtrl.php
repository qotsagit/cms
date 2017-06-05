<?php

/**
 * msgCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/msgModel.php';
include 'views/msgView.php';

class msgCtrl extends Ctrl
{
    
    public function __construct()
    {
        parent::__construct();
        $this->Model = new msgModel();
        $this->View = new msgView();
        
        $this->View->ButtonNew = false;
        $this->View->ViewTitle = $this->Msg('_MSG_','Messages');
        $this->View->CtrlName = CTRL_MSG;
        
        $this->Validator = new Validator();
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdMsg = new Input();
        $this->View->IdLang = new Input();
        $this->View->Const = new Input();
        $this->View->DefaultValue = new Input();
        $this->View->UserValue = new Input();
    }

    private function InitRequired()
    {
        //$this->View->Email->SetRequired(true);
        //$this->View->Nick->SetRequired(true);
        //$this->View->Password->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        //$this->Validator->Add($this->View->Name);
    }


    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdMsg->Value = filter_input(INPUT_POST, IDMSG);
        $this->View->UserValue->Value = filter_input(INPUT_POST, MSG_USER_VALUE);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_msg;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->IdMsg->Value = $item->id_msg;
            $this->View->Const->Value = $item->const;
            $this->View->DefaultValue->Value =  htmlspecialchars($item->default_value);
            $this->View->UserValue->Value = htmlspecialchars($item->user_value);
      
            return true;
        }

        return false;
    }

    public function Validate()
    {
        $this->ReadForm();
        return $this->Validator->Validate();
    }

    

    public function Insert()
    {
        $this->Model->id_msg = $this->View->IdMsg->Value;
        $this->Model->const = $this->View->Const->Value;
        $this->Model->default_value = $this->View->DefaultValue->Value;
        $this->Model->user_value = $this->View->UserValue->Value;
        
        if ($this->View->IdMsg->Value > 0)
        {
            $this->Model->Update();
        }
        else
        {
            $this->Model->Insert();
        }
        
       // $this->InitStrings(true); // inicjuje na nowo tablice z tłumaczeniami 
    }

    public function FormEdit()
    {
        $this->View->Title = $this->Msg('_EDIT_','Edit');

        if ($this->ReadDatabase($this->View->_Id))
        {
        
            $this->View->Render('msg/add');
        
        }else{
            
            new myException('DATABASE READ ERROR');
        }
    }
    
}

<?php

/**
 * templateCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/templateModel.php';
include 'views/templateView.php';

class templateCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();

        $this->View = new templateView();
        
        $this->View->ViewTitle = $this->Msg('_TEMPLATE_', 'Template');
        $this->View->CtrlName = CTRL_TEMPLATE;

        $this->Model = new templateModel();
        $this->Validator = new Validator();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdFile = new Input();
        $this->View->Name = new Input();
        $this->View->Content = new Input();
    }

    private function InitRequired()
    {
        $this->View->Name->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Name);    
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdFile->Value = filter_input(INPUT_POST, IDFILE);
        $this->View->Name->Value = filter_input(INPUT_POST, TEMPLATE_NAME);
        $this->View->Content->Value = filter_input(INPUT_POST, TEMPLATE_CONTENT);
    }

    public function ReadDatabase()
    {
        $item = $this->Model->GetById($this->View->_Id);
    
        if($item)
        {
            $this->View->Id->Value = $item->id_file;
            $this->View->IdFile->Value = $item->id_file;
            $this->View->Name->Value = $item->name;
            $this->View->Content->Value = $item->content;
            return true;
        }

        return false;
    }

    public function Insert()
    {

       $this->Model->id_file = $this->View->IdFile->Value;
       $this->Model->name = $this->View->Name->Value;
       $this->Model->content = $this->View->Content->Value;
        
        if ($this->View->IdFile->Value > 0)
        {
            $this->Model->Update();
        }
        else
        {
            $this->Model->Insert();
        }
    }
    
    public function DeleteConfirm()
    {
        $this->ReadForm();
        $this->Model->id = $this->View->Id->Value;
        $this->Model->Delete();
        $this->Listing();
    }
   
    public function FormAdd()
    {
        $this->View->Title = $this->Msg('_NEW_','New');
        $this->View->Render('template/add');
    }

    public function FormEdit()
    {
    
        $this->View->Title = $this->Msg('_EDIT_','Edit');
        
        if ($this->ReadDatabase())
        {
            $this->View->Render('template/add');
        }else{
             new myException('FILE MODEL ERROR');
        }
    }

}

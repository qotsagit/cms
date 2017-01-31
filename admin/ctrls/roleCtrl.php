<?php

/**
 * roleCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */


include 'models/roleModel.php';
include 'views/roleView.php';

class roleCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        $this->Model = new roleModel();
        $this->View = new roleView($this);
        $this->View->ViewTitle = $this->Msg('_ROLES_','Roles');
        $this->View->CtrlName = CTRL_ROLE;
        $this->Validator = new Validator();
        
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
        
    }

    private function InitFormFields()
    {
        $this->View->IdRole = new Input();
        $this->View->Name = new Input();        
    }

    private function InitRequired()
    {
        $this->View->Name->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Name);
    }

    public function Method()
    {
        switch ($this->Method)
        {
            case METHOD_ADD: $this->FormAdd();
                break;
            case METHOD_SAVE: $this->Save();
                break;
            case METHOD_DELETE: $this->FormDelete();
                break;
            case METHOD_EDIT: $this->FormEdit();
                break;
            default : $this->Index();
                break;
        }
    }

    public function ReadForm()
    {
        $this->View->IdRole->Value = filter_input(INPUT_POST, IDROLE);
        $this->View->Name->Value = filter_input(INPUT_POST, ROLE_NAME);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->IdRole->Value = $item->id;
            $this->View->Name->Value = $item->name;
            
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_role = $this->View->IdRole->Value;
        $this->Model->name = $this->View->Name->Value;
        
        if ($this->View->IdRole->Value > 0)
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
        $this->View->Render('role/add');
    }

    public function FormEdit()
    {
        if ($this->ReadDatabase($this->View->_Id))
        {
            $this->View->Render('role/add');
        
        }else{
            
            $this->View->Render('role/error');
            
        }
    }
    
}

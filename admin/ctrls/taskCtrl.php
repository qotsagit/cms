<?php

/**
 * taskCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/taskModel.php';
include 'models/userModel.php';
include 'models/activeModel.php';
include 'views/taskView.php';

class taskCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new taskView();
        $items = new activeModel();
        $this->View->Statuses = $items->All();
        $this->View->ViewTitle = $this->Msg('_TASKS_', 'Tasks');
        $this->View->CtrlName = CTRL_TASK;
        $this->View->SetColumns();

        $this->Model = new taskModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdTask = new Input();
        $this->View->IdUser = new Input();
        $this->View->Name = new Input();
        $this->View->Text = new Input();
        $this->View->Active = new Input();
        $this->View->Active->Value = STATUS_ACTIVE;
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
        $this->View->IdTask->Value = filter_input(INPUT_POST, IDTASK);
        $this->View->IdUser->Value = filter_input(INPUT_POST, IDUSER);
        $this->View->Name->Value = filter_input(INPUT_POST, TASK_NAME);
        $this->View->Text->Value = filter_input(INPUT_POST, TASK_TEXT);
        $this->View->Active->Value = filter_input(INPUT_POST, TASK_STATUS);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_task;
            $this->View->IdTask->Value = $item->id_task;
            $this->View->IdUser->Value = $item->id_user;
            $this->View->Name->Value = $item->name;
            $this->View->Text->Value = $item->text;
            $this->View->Active->Value = $item->active;
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_task = $this->View->IdTask->Value;
        $this->Model->id_user = Session::GetUser()->id_user;
        $this->Model->name = $this->View->Name->Value;
        $this->Model->text = $this->View->Text->Value;
        $this->Model->active = $this->View->Active->Value;

        if ($this->View->IdTask->Value > 0)
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
        $this->View->ViewTitle = $this->Msg('_ADD_', 'Add');
        $items = new userModel();
        $this->View->Users = $items->All();
        $this->View->Render('task/add');
    }

    public function FormEdit()
    {
        $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');
        $items = new userModel();
        $this->View->Users = $items->All();

        if ($this->ReadDatabase())
        {
            $this->View->Render('task/add');
        
        }else{
            
            $this->View->Render('error');
        }
    }
    
    

}

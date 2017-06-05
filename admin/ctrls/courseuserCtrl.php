<?php
/**
 * courseUserCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2017 maxkod.pl
 * @version    1.0
 */

include 'models/courseuserModel.php';
include 'views/courseuserView.php';

//pola formularza
define('COURSE_ID_COURSE','id_course');
define('COURSE_NAME','name');
define('COURSE_START_DATE','start_date');
define('COURSE_END_DATE','end_date');
define('COURSE_MAX_USERS','max_users');
define('COURSE_TEXT','text');

class courseuserCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new courseUserView();
        $this->Model = new courseUserModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdCourse = new Input();
        $this->View->IdUser = new Input();
        
    }

    private function InitRequired()
    {
        //$this->View->Name->SetRequired(true);
        //$this->View->Text->SetRequired(true);
        //$this->View->MaxUsers->SetRequired(true);
        //$this->View->StartDate->SetRequired(true);
        //$this->View->EndDate->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        //$this->Validator->Add($this->View->Name);
        //$this->Validator->Add($this->View->Text);
        //$this->Validator->Add($this->View->StartDate);
        //$this->Validator->Add($this->View->EndDate);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdCourse->Value = filter_input(INPUT_POST, ID);
        $this->View->Name->Value = filter_input(INPUT_POST, COURSE_NAME);
        $this->View->Text->Value = filter_input(INPUT_POST, COURSE_TEXT);
        $this->View->StartDate->Value = filter_input(INPUT_POST, COURSE_START_DATE);
        $this->View->EndDate->Value = filter_input(INPUT_POST, COURSE_END_DATE);
        $this->View->MaxUsers->Value = filter_input(INPUT_POST, COURSE_MAX_USERS);
        
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_course;
            $this->View->IdCourse->Value = $item->id_course;
            $this->View->Name->Value = $item->name;
            $this->View->Text->Value = htmlspecialchars($item->text);
            $this->View->StartDate->Value = $item->start_date;
            $this->View->EndDate->Value = $item->end_date;
            $this->View->MaxUsers->Value = $item->max_users;
            
            return true;
        }

        return false;
    }

    public function SetValues()
    {
        $this->Model->id_course = $this->View->IdCourse->Value; 
        $this->Model->name = $this->View->Name->Value;
        $this->Model->text = $this->View->Text->Value;
        $this->Model->start_date = $this->View->StartDate->Value;
        $this->Model->end_date = $this->View->EndDate->Value;
        $this->Model->max_users = $this->View->MaxUsers->Value;
    }

    public function Insert()
    {
        $this->SetValues();
        $this->Model->Insert();
    }
    
    public function Update()
    {
        $this->SetValues();
        $this->Model->Update();
    }
   
    public function FormAdd()
    {
        Settings::$CKEditorUse = true;
        $this->View->ViewTitle = $this->Msg('_ADD_', 'Add');
        $this->View->Render('courseuser/add');
    }

    public function FormEdit()
    {
        Settings::$CKEditorUse = true;
        
        if ($this->ReadDatabase())
        {
            $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');        
            $this->View->Render('courseuser/add');
        
        }else{

            $this->View->Render('error');
        }
    }
    
    
}

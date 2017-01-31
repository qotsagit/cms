<?php
/**
 * calendarCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/calendarModel.php';
include 'views/calendarView.php';

class calendarCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new calendarView();
        $this->View->ViewTitle = $this->Msg('_CALENDAR_', 'Calendar');
        $this->View->CtrlName = CTRL_CALENDAR;
        $this->View->SetColumns();

        $this->Model = new calendarModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdCalendar = new Input();
        $this->View->StartDate = new Input();
        $this->View->EndDate = new Input();
        $this->View->Name = new Input();
        $this->View->Text = new Input();
    }

    private function InitRequired()
    {
        $this->View->Name->SetRequired(true);
        $this->View->Text->SetRequired(true);
        $this->View->StartDate->SetRequired(true);
        $this->View->StartDate->SetDate($this->View->StartDate,$this->View->EndDate);
        
        $this->View->EndDate->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Name);
        $this->Validator->Add($this->View->StartDate);
        $this->Validator->Add($this->View->EndDate);
        $this->Validator->Add($this->View->Text);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdCalendar->Value = filter_input(INPUT_POST, IDCALENDAR);
        
        $this->View->StartDate->Value = filter_input(INPUT_POST, CALENDAR_START_DATE);
        $this->View->EndDate->Value = filter_input(INPUT_POST, CALENDAR_END_DATE);
        
        $this->View->Name->Value = filter_input(INPUT_POST, CALENDAR_NAME);
        $this->View->Text->Value = filter_input(INPUT_POST, CALENDAR_TEXT);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_calendar;
            $this->View->IdCalendar->Value = $item->id_calendar;
            $this->View->StartDate->Value = $item->start_date;
            $this->View->EndDate->Value = $item->end_date;
            $this->View->Name->Value = $item->name;
            $this->View->Text->Value = htmlspecialchars($item->text);

            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_calendar = $this->View->IdCalendar->Value;
        $this->Model->start_date =  $this->View->StartDate->Value;
        $this->Model->end_date =  $this->View->EndDate->Value;
        $this->Model->name = $this->View->Name->Value;
        $this->Model->text = $this->View->Text->Value;
        

        if ($this->View->IdCalendar->Value > 0)
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
        $this->View->Render('calendar/add');
    }

    public function FormEdit()
    {       
        $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');

        if ($this->ReadDatabase())
        {
            $this->View->Render('calendar/add');
        
        }else{

            $this->View->Render('error');
        }
    }
    
}

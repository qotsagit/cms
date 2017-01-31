<?php

class calendarView extends View
{
    // pola formularza
    public $_Id;
    public $IdCalendar;
    public $StartDate;
    public $EndDate;
    public $Name;
    public $Text;

         
    public function __construct()
    {    
        parent::__construct();
    }
    
    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_calendar',false),
            new ColumnText($this->Msg('_NAME_','Name'),'name'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text'),
            new ColumnText($this->Msg('_START_DATE_','Start date'),'start_date'),
            new ColumnText($this->Msg('_END_DATE_','End date'),'end_date'),
            
        );    
    }
    
    
}

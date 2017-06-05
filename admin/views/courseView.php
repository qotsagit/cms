<?php

class courseView extends View
{
         
    public function __construct()
    {    
        parent::__construct();
        $this->CtrlName = CTRL_COURSE;
        $this->ViewTitle = $this->Msg('_COURSE_', 'Course');  
    }
    
    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_course',false),
            new ColumnText($this->Msg('_NAME_','Name'),'name'),
            new ColumnText($this->Msg('_START_DATE_','Start date'),'start_date'),
            new ColumnText($this->Msg('_END_DATE_','End date'),'end_date'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text',false),
            //new ColumnText($this->Msg('_ADDED_TIME_','Added Time'),'added_time')
        );    
    }
    
    
    
    //nadpisujemy 
    //public function render($view)
    //{
      //  include TEMPLATE_FOLDER . '/' . $view . '.html';
    //}

    
}

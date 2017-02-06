<?php

class newsletterView extends View
{
    // pola formularza
       
    
         
    public function __construct()
    {    
        parent::__construct();
    }
    
    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_newsletter',false),
            new ColumnLink($this->Msg('_TITLE_','Title'),'title'),
            new ColumnText($this->Msg('_START_DATE_','Start date'),'start_date'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text')
            //new ColumnText($this->Msg('_POSITION_','Position'),'position'),
            //new ColumnActive($this->Msg('_ACTIVE_','Active'), 'active',$this->Statuses)
        );
    }
     
}

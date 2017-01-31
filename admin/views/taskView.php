<?php

class taskView extends View
{
    // pola formularza
    public $_Id;
    public $IdTask;
    public $IdUser;
    public $Name;
    public $Active;

    public function __construct()
    {    
        parent::__construct();    
    }

    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_task',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_user',false),
            new ColumnText($this->Msg('_NAME_','Name'),'name'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text'),
            new ColumnText($this->Msg('_START_DATE_','Start Date'),'start_date'),
            new ColumnActive($this->Msg('_ACTIVE_','Active'), 'active',$this->Statuses)
        );
    }
    
}

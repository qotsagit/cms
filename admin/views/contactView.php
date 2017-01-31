<?php

class contactView extends View
{
    
    public function __construct()
    {   
        parent::__construct();
          
    }

    public function SetColumns()
    {
        $this->Columns = array
            (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_contact',false),
            new ColumnText($this->Msg('_EMAIL_','Email'), 'email'),
            new ColumnText($this->Msg('_FIRST_NAME_','First Name'), 'first_name'),
            new ColumnText($this->Msg('_LAST_NAME_','Last Name'), 'last_name'),
            new ColumnText($this->Msg('_SUBJECT_','Subject'), 'subject'),
            new ColumnText($this->Msg('_MESSAGE_','Message'), 'message'),
            new ColumnText($this->Msg('_DATE_','Date'), 'date')
        );
    }
    
}

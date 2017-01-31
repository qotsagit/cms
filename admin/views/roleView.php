<?php

class roleView extends View
{
    // pola formularza
    public $IdRole;
    public $Name;

    public function __construct()
    {
        parent::__construct();
         $this->Columns = array
            (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_role',false),
            new ColumnText($this->Msg('_NAME_','Name'), 'name')
            
        );
         
    }

}


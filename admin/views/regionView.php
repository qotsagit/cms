<?php

class regionView extends View
{
    // pola formularza
    public $_Id;
    public $IdRegion;
    public $Name;
             
    public function __construct()
    {    
        parent::__construct();
    }
    
    public function SetColumns()
    {    
         $this->Columns = array
            (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_region',false),
            new ColumnText($this->Msg('_NAME_','Name'), 'name')
        );
        
    }
    

}

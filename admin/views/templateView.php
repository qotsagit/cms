<?php

class templateView extends View
{
    // pola formularza  
    public $Id;
    public $Name;
    public $OldName;
    
    public function __construct()
    {    
        parent::__construct();
        
    }
    
    public function SetColumns()
    {
        
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_file',false),
            new ColumnText($this->Msg('_NAME_','Name'), 'name'),
            new ColumnText($this->Msg('_SIZE_','Size'), 'size')
            //new ColumnStatus($this->Msg('_STATUS_','Status'), 'status',$this->Statuses)
        );
        
    }
 
}

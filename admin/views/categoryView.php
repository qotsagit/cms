<?php

class categoryView extends View
{
    public $IdCategory;
    public $IdLang;
    public $Name;
    
    public function __construct()
    {
        parent::__construct();
         $this->Columns = array
            (
            new ColumnText($this->Msg('_EMPTY_STRING_',''), 'id_category',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''), 'id_lang',false),
            new ColumnLink($this->Msg('_NAME_','Name'), 'name'),
        );       
        
    }

}


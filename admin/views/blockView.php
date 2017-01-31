<?php

class blockView extends View
{
    // pola formularza
    public $_Id;
    public $IdBlock;
    public $IdUser;
    public $IdLang;
    public $Title;
    public $Description;
    public $Active;

         
    public function __construct()
    {    
        parent::__construct();
    }
    
    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_block',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''), 'id_user',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''), 'id_region',false),
            new ColumnText($this->Msg('_POSITION_','Position'), 'position',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''), 'id_lang',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''), 'content_type',false),
            new ColumnText($this->Msg('_TITLE_','Title'),'title'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'img'),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'show_type',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'show_url'),
            new ColumnText($this->Msg('_ADDED_TIME_','Added Time'),'added_time'),
            new ColumnActive($this->Msg('_ACTIVE_','Active'), 'active',$this->Statuses)
        );    
    }
    
    
    
    //nadpisujemy 
    //public function render($view)
    //{
      //  include TEMPLATE_FOLDER . '/' . $view . '.html';
    //}

    
}

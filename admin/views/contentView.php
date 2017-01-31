<?php

class contentView extends View
{
    // pola formularza
    public $IdContent;
    public $IdLang;
    public $Title;
    public $Description;
    public $Statuses;       // lista statusów

    public function __construct()
    {
         parent::__construct();

        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_content',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_user',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_category',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_lang',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_user',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'content_type',false),
            new ColumnText($this->Msg('_TITLE_','Title'),'title'),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'description',false)
        );

    }

}

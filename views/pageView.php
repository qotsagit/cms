<?php

class pageView extends View
{
    public function __construct()
    {    
        parent::__construct();
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_page',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_user',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_category',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_parent',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_lang',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'content_type',false),
            new ColumnText($this->Msg('_TITLE_','Title'),'title',false),
            new ColumnText($this->Msg('_TEXT_','Text'),'text',false),
            new ColumnImage($this->Msg('_EMPTY_STRING_',''),'img',100,100,false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'price',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'price_type',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'meta_title',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'meta_description',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'url',false),
			new ColumnUrlAddress($this->Msg('_EMPTY_STRING_',''),'url_address','title'),
            new ColumnText($this->Msg('_ADDED_TIME_','Added Time'),'added_time',false),
            new ColumnText($this->Msg('_POSITION_','Position'),'position',false),
            
        );
		
    }

}

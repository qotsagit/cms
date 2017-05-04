<?php

class placeView extends View
{
         
    public function __construct()
    {    
        parent::__construct();
        $this->ViewTitle = $this->Msg('_PLACE_', 'Place');
        $this->CtrlName = CTRL_PLACE;
    }
    
    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_place',false),
            new ColumnText($this->Msg('_TITLE_','Title'),'title'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text'),
            new ColumnText($this->Msg('_LON_','Lon'),'lon'),
            new ColumnText($this->Msg('_LAT_','Lat'),'lat')
        );    
    }
    

}

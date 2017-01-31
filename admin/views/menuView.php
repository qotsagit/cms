<?php

class menuView extends View
{
    // pola formularza
    public $_Id;
    public $IdMenu;
    public $IdRegion;
    public $IdLang;
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
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_menu',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_region',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_lang',false),
            new ColumnIcon($this->Msg('_EMPTY_STRING_',''),'id_parent',true),
            new ColumnLink($this->Msg('_NAME_','Name'),'name'),
            new ColumnText($this->Msg('_URL_','Url'),'url'),
            new ColumnText($this->Msg('_POSITION_','Position'),'position'),
            new ColumnActive($this->Msg('_ACTIVE_','Active'), 'active',$this->Statuses)
        );
    }
    
    /*
    public function RenderRowMenu($view, $item)
    {
        print '<div class="btn-group">';
        print '<a class="btn btn-default btn-sm" href="' . $view->CtrlName . '/' . METHOD_EDIT. '/' . $item->GetId() . '")>' . $view->Msg('_EDIT_', 'Edit') . '</a></button>';
        print '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
        print '<ul class="dropdown-menu" role="menu">';
        print '<li><a href="' . CTRL_MENUITEMS . '/' . METHOD_VIEW . '/' . $item->GetId() . '")>' . $view->Msg('_ITEMS_', 'Items') . '</a></li>';
        //print '<li class="divider"></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        
        print '</ul>';
        print '</div>';
    }
    */
    
}

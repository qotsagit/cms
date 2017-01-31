<?php

class msgView extends View
{
    // pola formularza
    public $IdMsg;
    public $IdLang;
    public $Const;
    public $UserValue;
    public $DefaultValue;
   
    public function __construct()
    {   
        parent::__construct();
        
    }
    
    public function SetColumns()
    {
            $this->Columns = array
            (
                new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_msg',false),
                new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_lang',false),
                new ColumnText($this->Msg('_NAME_','Name'), 'const'),
                new ColumnText($this->Msg('_USER_VALUE_','User Value'), 'user_value'),
                new ColumnText($this->Msg('_DEFAULT_VALUE_','Default Value'), 'default_value')
            );
    }
    
    // nadpisujemy menu
    public function RenderRowMenu($view, $item)
    {
        
         print '<div class="btn-group">';
            print '<a class="btn btn-default btn-sm" href="' . $view->CtrlName . '/' . METHOD_EDIT. '/' . $item->GetId() . '")>' . $view->Msg('_EDIT_', 'Edit') . '</a></button>';
            //print '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
            //print '<ul class="dropdown-menu" role="menu">';
            //print '<li><a href="' . $view->CtrlName . '/' . METHOD_VIEW . '/' . $item->GetId() . '")>' . $view->Msg('_VIEW_', 'View') . '</a></li>';
            //print '<li><a href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></li>';
            //print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
            //print '</ul>';
            print '</div>';
        
        
        //print '<li><a href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></li>';
    }

}

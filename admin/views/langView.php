<?php

class langView extends View
{
    // pola formularza
    public $IdLang;
    public $Code;
    public $Name;
   
    public function __construct()
    {   
        parent::__construct();
          
    }

    public function SetColumns()
    {
        $this->Columns = array
            (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_lang',false),
            new ColumnText($this->Msg('_NAME_','Name'), 'name'),
            new ColumnText($this->Msg('_CODE_','Code'), 'code'),
            new ColumnActive($this->Msg('_ACTIVE_','Active'), 'active',$this->Statuses)
        );
    }
    
    // nadpisujemy menu
    //public function RenderRowMenu($view, $item)
    //{
       // print '<li><a href="' . $view->CtrlName . '/' . METHOD_VIEW . '/' . $item->GetId() . '")>' . $view->Msg('_VIEW_', 'View') . '</a></li>';
//        print '<li><a href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></li>';
  //      print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
    //    print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        //print '<li><a href="#" class="delete-button" data-toggle="modal" data-target="#myModal" data-id="'.$item->GetId().'">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        //print '<button class="btn btn btn-danger edit-button" type="button" data-name="test nazwy" data-toggle="modal" data-target="#myModal">'.$view->Msg('_DELETE_', 'Delete').'</button>';
    //}

}

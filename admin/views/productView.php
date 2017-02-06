<?php

class pageView extends View
{
    // pola formularza

    public $IdPage;
    public $IdLang;
    public $Title;
    public $Description;
    public $Statuses;       // lista statusów

    public function __construct()
    {
         parent::__construct();
    }

    public function SetColumns()
    {
        $this->Columns = array
        (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_page',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_user',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_category',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_parent',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_lang',false),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'content_type',false),
            new ColumnImage($this->Msg('_EMPTY_STRING_',''),'img',50,50,true),
            new ColumnPreview($this->Msg('_EMPTY_STRING_',''),'id_parent',true),
            new ColumnIcon($this->Msg('_EMPTY_STRING_',''),'id_parent',true),
            new ColumnLink($this->Msg('_TITLE_','Title'),'title'),
            new ColumnText($this->Msg('_TEXT_','Text'),'text',false),
            new ColumnText($this->Msg('_PRICE_','Price'),'price',true),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'price_type',false),
            new ColumnText($this->Msg('_META_TITLE_','Meta Title'),'meta_title',true),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'meta_description',true),
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'url',false),
            new ColumnUrl($this->Msg('_URL_','Url'),'url_address',true),
            new ColumnText($this->Msg('_ADDED_TIME_','Added Time'),'added_time',true),
            new ColumnText($this->Msg('_TEMPLATE_','Template'),'template',true),
            new ColumnText($this->Msg('_POSITION_','Position'),'position',true),
            new ColumnActive($this->Msg('_ACTIVE_','Active'),'active',$this->Statuses,true),
        );
    }

    public function RenderRowMenu($view, $item)
    {
        print '<div class="btn-group">';
        print '<a class="btn btn-default btn-sm" href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></button>';
        print '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
        print '<ul class="dropdown-menu" role="menu">';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_COPY . '/' . $item->GetId() . '")>' . $view->Msg('_COPY_', 'Copy') . '</a></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_PREVIEW . '/' . $item->GetId() . '")>' . $view->Msg('_PREVIEW_', 'Preview') . '</a></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        print '</ul>';
        print '</div>';

        //print '<li><a href="#" class="delete-button" data-toggle="modal" data-target="#myModal" data-id="'.$item->GetId().'">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        //print '<button class="btn btn btn-danger edit-button" type="button" data-name="test nazwy" data-toggle="modal" data-target="#myModal">'.$view->Msg('_DELETE_', 'Delete').'</button>';
    }
    
    /*
    public function RenderButtonNew($view)
    {
        if ($view->ButtonNew)
        {
            print '<div class="btn-group">';
            print '<a class="btn btn-default btn-sm" href="' . $view->CtrlName . '/' . METHOD_ADD.'">' . $this->Msg('_NEW_', 'New') . '</a></button>';
            print '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
            print '<ul class="dropdown-menu" role="menu">';
            print '<li><a href="' . $view->CtrlName . '/' . METHOD_ADD. '">' . $this->Msg('_NEW_', 'New') . '</a></li>';
            print '<li><a href="' . $view->CtrlName . '/' . METHOD_ADD_NEWS. '">' . $this->Msg('_NEWS_', 'News') . '</a></li>';
            print '<li><a href="' . $view->CtrlName . '/' . METHOD_ADD_PRODUCT. '">' . $view->Msg('_PRODUCT_', 'Product') . '</a></li>';
            print '<li><a href="' . $view->CtrlName . '/' . METHOD_ADD_GALLERY. '">' . $view->Msg('_GALLERY_', 'Gallery') . '</a></li>';
            //print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
            print '</ul>';
            print '</div>';
                        
            //print '</div>';
        }
        
    }
    */

}

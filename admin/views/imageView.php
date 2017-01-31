<?php

class imageView extends View
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
            new ColumnText($this->Msg('_NAME_','Name'), 'name',true),
            new ColumnImage($this->Msg('_IMAGE_','Image'), 'img',80,80),
        );
    }
    
    
    public function RenderImages()
    {
        foreach ($this->Items as $item)
        {   
            print '<div class="col-md-2 col-sm-4 col-xs-12"><div class="text-center">';
            print '<div class="thumbnail">';
            print '<a href="" data-toggle="modal" data-target="#myModal" >';
            print '<img draggable="true" ondragstart="drag(event)" onclick="loadImage(this)" class="img img-thumbnail" src='.$this->ImageUrl($item->img,'mini').' width1=150 height1=150>';
            print '</a>';
            print '<div class="caption">';
            //print '<div id="upload"><span class="glyphicon glyphicon-remove"></span></div>';
            //print '<progress id="progressBar'+$item->GetId()+'" style="display:none" max="100" style="width:150px;"></progress>';
            //'<h1 id="status'+id+'"></h1>'+
            //print '<div id="loaded_n_total'+$item->GetId()+'"></div>';
            //print '<a href="#" role="button"><span class="glyphicon glyphicon-trash"></span></a>';
            //print '<a href="#" class="btn-sm btn-default" role="button">Button</a>';
            $this->RenderRowMenu($this,$item);
            print '</div>';
            print '</div>';
            print '</div>';
            print '</div>';
        }
        
    }
    
    //public function RenderTableHeader($view)
    //{
        
        
    //}

}

<?php


class View extends Base
{

    public $_Id = 0;                        // główne id
    public $_IdParent = 0;                  // id rodzica
    public $ViewTitle;                      // tytuł widoku
    public $LimitFrom = 0;
    public $OrderColumnId = 0;              // kolumna sortowania
    public $Asc = SORT_ASC;                 // rosnąco, malejąco
    public $Limit = DEFAULT_LIMIT;          // limit dla stronicowania
    public $Page = 1;                       // która strona
    public $Search;                         // tekst wyszukiwania
    public $Columns;                        // definicja kolumn do wyświetlania danych
    public $Items;                          // lista rekordów zwrócona przez model
    public $BreadcrumbItems = array();      // lista scieżki
    public $CurrentItem = NULL;             // aktualna strona wyświetlana
    public $Maintenance = MAINTENANCE_MODE; // konserwacja strony 
    public $Saved = false;                  // prawidłowo zapisany formularz
    public $Validation = VALIDATION_NONE;   // status validacji
    public $PageTitle;                      // tytuł strony
    
    public $Model;
    public $CtrlName;
    public $Count = 0;
    public $Text;                           // tekst dla komunikatu delete
    public $ButtonNew = true;               // czy button NEW ma być widoczny


    public function __construct()
    {
        parent::__construct();
    }

    public function SetModel($model)
    {
        $this->Model = $model;
        $model->id_parent = $this->_IdParent; // ustawiamy przed Count
        $this->Count = $model->Count();
        $this->CountAll = $model->CountAll();
        $model->Asc = $this->Asc;
        $model->Limit = $this->Limit;
        
        $this->CheckPage();
        $this->SetPage($model);
        
        $this->CheckColumns($model);        
        
        $this->SetParent($model);
        
        //$this->RowCount = $model->RowCount();     
    }
 
    public function SetItems($model)
    {
        $this->Items = $model->Lists();
    }
    
    private function CheckColumns($model)
    {
        //check columns
        if (count($this->Columns) > $this->OrderColumnId)
        {
            $column = $this->Columns[$this->OrderColumnId];
            $model->OrderFieldName = $column->FieldName;
        
        }else{
            
            //new myException('Columns Error',count($this->Columns).' - '.$this->OrderColumnId);
        }
    }

    private function CheckPage()
    {
        if ($this->Limit == 0)
        {
            $this->Pages = 1;
        
        }else{
            
            $this->Count;
            $this->Pages = ceil(($this->Count / $this->Limit));
        }

        if ($this->Pages <= $this->Page - 1)
        {
            Session::SetPage(1);
            $this->Page = 1;
        }
    }

    private function SetPage($model)
    {
        $model->LimitFrom = ($this->Page * $this->Limit) - $this->Limit;
        $model->Page = $this->Page;
    }
    
    private function SetParent($model)
    {
        
        if($this->_IdParent > 0)
        {
            $row = $model->GetParentId($this->_IdParent);          
            $this->_Id = $row->id_parent;
            $model->Breadcrumb($row->id);
            $this->BreadcrumbItems = $model->breadcrumb;
            $this->CurrentItem = $model->GetCurrentItem();
            //}
        }else{
            
            // strona startowa
            $this->CurrentItem = $model->GetCurrentItem();
            if($this->CurrentItem)
                $model->id_parent = $this->CurrentItem->id_page;
            
        }
    }
   
    public function SetColumns()
    {

    }  
    
    public function RenderMaintenance()
    {
        if($this->Maintenance)
        {
            print '<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> '.$this->Msg('_MAINTENANCE_','Maintenance').'</div>';
        } 
    }
    
    public function RenderError($text)
    {
        if ($text)
        {
            print "<div class='alert alert-danger' role='alert'>$text</div>";
        }
    }

    public function RenderInfo($text)
    {
        print "<div class='alert alert-info' role='alert'>$text</div>";
    }

    public function RenderValidationError($list)
    {
        foreach($list as $item)
        {
            print "<div class='text-danger'>$item</div>";
        }

    }

    public function RenderValidationMessage()
    {
        if($this->Validation == VALIDATION_FALSE)
        {
            print '<div class="alert alert-danger">'.$this->Msg('_VALIDATION_ERROR_','Validation Error').'</div>';
        } 
    }
    
    
    public function RenderImage($src,$value,$width,$height)
    //public function RenderImage($width,$height)
    {
        //print '<link rel="stylesheet" href="style/simplex/css/image.css">';
        //print '<link rel="stylesheet" href="style/simplex/css/imageffect.css">';
        print '<div class="text-center">';
        //print '<a href="user" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"> </span> </a>';
        print '<span class="btn btn-file">';
        print '<img id="image" src='.$src.' class="img img-circle" width='.$width.' height='.$height.'>'; 
        print '<input type="file" id="inputfile" name="avatar[]" onchange="handleFiles(this.files,image)" accept="image/*"></span>';
        //print '<input type="hidden" name="'.AVATAR.'" value="'.$value.'">';
        print '</div>';
        //print '<div class="panel" id="preview">';  
        //print '<a href="#" class="info" title="Full Image">Delete</a>';  
        //print '</div>';
        //print '</div>';
    }
    
    public function RenderOneImage($src,$width,$height)
    {
        //print '<link rel="stylesheet" href="style/simplex/css/image.css">';
        //print '<link rel="stylesheet" href="style/simplex/css/imageffect.css">';
        print '<div class="text-center">';
        //print '<a href="user" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"> </span> </a>';
        print '<span class="btn btn-file">';
        print '<img id="image" src="'.$src.'" class="img img-circle" width='.$width.' height='.$height.'>'; 
        print '<input type="file" id="inputfile" name="img" onchange="handleFiles(this.files,image)" accept="image/*"></span>';
        print '<input type="hidden" name="'.AVATAR.'" value="'.$src.'">';
        print '</div>';
        //print '<div class="panel" id="preview">';  
        //print '<a href="#" class="info" title="Full Image">Delete</a>';  
        //print '</div>';
        //print '</div>';
    }

    public function RenderUploader($id)
    {
        print '<div class="text-center">';
        print '<div class="panel" id="preview"></div>';
        print '<span class="btn btn-file">';
        print '<img id="avatar" class="img img-circle" width=150 height=150>';
        //print '<input type="file" id="inputfile" name="avatar[]" onchange="uploadFile(this,avatar)" accept="image/*"></span>';
        print '<div id="upload"></div>';
        print '<progress id="progressBar" style="display:none" max="100" style="width:300px;"></progress>';
        print '<h3 id="status"></h3>';
        print '<p id="loaded_n_total"></p>';
        print '</div>';
    }

    public function RenderBreadcrumb($view) 
    {
        //if($view->_IdParent > 0)
        //{
            print '<ul class="breadcrumb">';
            print '<li><a href="'.$view->CtrlName.'/'.METHOD_PARENT.'/0">'.$view->ViewTitle.'</a></li>';
            foreach ($view->BreadcrumbItems as $item)
            {
                print '<li><a href="'.$view->CtrlName.'/'.METHOD_PARENT.'/'.$item->GetId().'" >'.$item->GetName().'</a></li>';
            }
        
            print '</ul>';
        //}
    }

    public function RenderButtonNew($view)
    {
        if ($view->ButtonNew)
        {
            print ' <a href="' . $view->CtrlName . '/' . METHOD_ADD . '" class="btn btn-default btn-sm">' . $this->Msg('_NEW_', 'New') . '</a>';
            //print '</div>';
        }
        
    }
    
    // header for listing
    public function RenderListHeader($view)
    {
       
        print '<div class="panel panel-default">';
        print '<div class="col-md-5 col-sm-12">';

        $this->RenderButtonNew($view);        
        
        //print '<div class="col-md-2 col-sm-12">';
        //print ' <a href="#" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-up"></span>sele</a>';
        print ' <a href="' . $view->CtrlName . '" class="btn btn-default btn-sm">' . $view->ViewTitle . ' <span class="label label-danger"> ' . $view->Count . '</span></a>';
        //print '</div>';
                
        //print '<div class="col-md-2 col-sm-12">';
        print ' ';
        foreach (Settings::$Limits as $limit)
        {
            if ($view->Limit == $limit)
            {
                print '<a href="'.$view->CtrlName.'/'.METHOD_LIMIT.'-'.$limit.'" class="btn btn-primary btn-sm">' . $limit . '</a>';
            }
            else
            {
                print '<a href="'.$view->CtrlName.'/'.METHOD_LIMIT.'-'. $limit.'"  class="btn btn-default btn-sm">' . $limit . '</a>';
            }
        }
        
        print '</div>';
        print '<div class="col-md-7 col-sm-12">';
        print '<form method="POST">';
        print '<div class="input-group">';
        print '<input type="text" class="form-control" name="'.SEARCH.'" value="'.Session::GetSearch().'" placeholder="'.$this->Msg('_SEARCH_','Search').'">';
        print '<input type="hidden" name="'.METHOD.'" value="'.METHOD_SEARCH.'">';
        print '<span class="input-group-btn">';
        print '<button class="btn btn-default" type="submit">'.$this->Msg('_SEARCH_','Search').'</button>';
        print '</span>';
        print '</div>';
        print '</form>';
        print '</div>';
        //print '</div>';
        
        //print '<div class="panel-heading">';
        print '<div class="row">';
        print '<div class="col-md-12 col-sm-12">';
        
        //print '<div class="col-md-9 col-sm-12">';
        $this->RenderBreadcrumb($view);
        //print '</div>';
       
        print '</div>';
        print '</div>';        
        print '</div>';

    }

    public function RenderTableHeader()
    {

        print '<thead>';
        print '<tr>';
        print '<th><center><input type="checkbox" id="select_all"></center>';
        //print '<a id="select_all" href=""><span class="glyphicon glyphicon glyphicon-ok"> </span> </a>';
        //print '<a id="remove_selected" href="#"><span class="glyphicon glyphicon glyphicon-remove"> </span> </a>';
        //print '<a id="remove_selected" href="#"><span class="glyphicon glyphicon glyphicon-remove"> </span> </a>';
        print '</th>';  //checkbox select
                
        print '<th>';
        if($this->_IdParent > 0)
            print '<a href="' . $this->CtrlName .'/'.METHOD_PARENT.'/'.$this->_Id.'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-up"></span></a>';
        print '</th>';
        
        print '<th></th>'; // liczba porządkowa

        $id = 0;

        foreach ($this->Columns as $column)
        {
            if ($column->Visible)
            {
                if ($this->OrderColumnId == $id)
                {
                    if ($this->Asc == SORT_ASC)
                    {
                        print '<th><a href="'.$this->CtrlName.'/'.METHOD_ORDER.'-'.$id.'/'.METHOD_ASC.'-'.SORT_DESC.'">' . $column->Name . '</a>';
                        print '<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></th>';
                    }
                    else
                    {
                        print '<th><a href="' . $this->CtrlName.'/'.METHOD_ORDER .'-'.$id.'/'.METHOD_ASC.'-'.SORT_ASC.'">' . $column->Name . '</a>';
                        print '<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></th>';
                    }
                }
                else
                {
                    print '<th><a href="' . $this->CtrlName.'/'.METHOD_ORDER .'-'.$id.'/'.METHOD_ASC.'-'.SORT_ASC.'">' . $column->Name . '</a></th>';
                }
            }
            $id++;
        }

        print '</tr>';
        print '</thead>';
    }

    

    public function RenderTableBody($view)
    {
        //$count = sizeof($view->Columns);
        print '<tbody>';
        //print '<tr><td colspan=$count></tr>';
        $id = ($view->Page * $view->Limit) - $view->Limit + 1;
    
        
        foreach ($view->Items as $item)
        {
            if($item->GetActive() == STATUS_NOT_ACTIVE)
                $strikeout = 'strikeout';
            else
                $strikeout = '';

            if ($view->_Id == $item->GetId())
                print '<tr id="tr'.$item->GetId().'" class="success '.$strikeout.' ">';
            else
                print '<tr id="tr'.$item->GetId().'" class="'.$strikeout.'">';
            
            print '<td width="50px;" id="column_select"><center><input type="checkbox" name="'.IDSELECTED.'" value="'.$item->GetId().'"></center></td>';
            print '<td width="140px;">';
            $this->RenderRowMenu($view, $item);
            print '</td>';
            print '<td class="text-right">' . $id . '</td>';

            foreach ($view->Columns as $column)
            {
                if ($column->Visible)
                {
                    print '<td>';
                    $column->Render($view,$item);
                    print '</td>';
                }
            }

            print '</tr>';
            $id++;
        }
        
       
        print '</tbody>';
        
    }
    
    public function RenderTableActions()
    {
        //print '<div class="panel panel-default">';
        //print '<div class="panel-body">';
        
        //print $this->Msg('_SELECTED_','Selected');
        //print '<br>';
        //print '<div id="selected_count"></div>';
        //print '<a href="user"><span class="glyphicon glyphicon-remove"></span></a>';
        
        //print '<div class="btn-group" id="button_delete_selected">';
        //print '<a class="btn btn-default btn-sm" href="' . $this->CtrlName . '/' . METHOD_DELETE .'")>' . $this->Msg('_DELETE_', 'Delete') . '</a></button>';
        //print '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
        //print '<ul class="dropdown-menu" role="menu">';
        //print '<li><button type="submit" class="btn btn-default btn-sm">delete</button></li>';
        //print '<li><button type="submit" class="btn btn-default btn-sm">save</button></li>';
        //print '<li><a href="' . $view->CtrlName . '/' . METHOD_VIEW . '/' . $item->GetId() . '")>' . $view->Msg('_VIEW_', 'View') . '</a></li>';
        //print '<li><a href="' . $this->CtrlName . '/' . METHOD_DELETE . '">' . $this->Msg('_DELETE_', 'Delete') . '</a></li>';
        //print '<li><a href="' . $this->CtrlName . '/' . METHOD_COPY . '">' . $this->Msg('_COPY_', 'Copy') . '</a></li>';
        //print '</ul>';
        
        print '<div class="col-md-12">';
        print '<button type="submit" name="method" value="delete" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
        print '<button type="submit" name="method"  value="copy" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-copy"></span></button>';
        //print '</div>';
        //print '<div class="col-md-2">';
        print '<form method="POST">';
		print '<div class="form-group">';
		print $this->RenderLanguages();
		print '</div>';
		print '</form>';
        print '</div>';
        
    }
    
    

    public function RenderRowMenu($view, $item)
    {
        print '<div class="btn-group">';
        print '<a class="btn btn-default btn-sm" href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '")>' . $view->Msg('_EDIT_', 'Edit') . '</a></button>';
        print '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
        print '<ul class="dropdown-menu" role="menu">';
        //print '<li><a href="' . $view->CtrlName . '/' . METHOD_VIEW . '/' . $item->GetId() . '")>' . $view->Msg('_VIEW_', 'View') . '</a></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_EDIT . '/' . $item->GetId() . '">' . $view->Msg('_EDIT_', 'Edit') . '</a></li>';
        print '<li><a href="' . $view->CtrlName . '/' . METHOD_DELETE . '/' . $item->GetId() . '">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        print '</ul>';
        print '</div>';

        //print '<li><a href="#" class="delete-button" data-toggle="modal" data-target="#myModal" data-id="'.$item->GetId().'">' . $view->Msg('_DELETE_', 'Delete') . '</a></li>';
        //print '<button class="btn btn btn-danger edit-button" type="button" data-name="test nazwy" data-toggle="modal" data-target="#myModal">'.$view->Msg('_DELETE_', 'Delete').'</button>';
    }
    
    public function RenderSelectedPage($view, $title = true, $code_start = '<section class="page-header page-header-xs"><div class="container"><h1>', $code_end = '</h1></div></section>')
    {

        if($view->CurrentItem)
        {
            if($title)
            {
                /*print '<section class="page-header page-header-xs">';
                print '<div class="container">';
                print '<h1>'.$view->CurrentItem->title.'</h1>';
                print '</div>';
                print '</section>';*/
                print $code_start;
                print $view->CurrentItem->title;
                print $code_end;
            }
            
            print $view->CurrentItem->text;
        }
    }
    
    public function RenderSelectedPageTitle($view, $code_start = '<section class="page-header page-header-xs"><div class="container"><h1>', $code_end = '</h1></div></section>')
    {

        if($view->CurrentItem)
        {
            print $code_start;
            print $view->CurrentItem->title;
            print $code_end;

        }
            
    }
    
    public function RenderSelectedPageContent($view, $code_start = '<section><div class="container"><div class="row">', $code_end = '</div></div></section>')
    {

        if($view->CurrentItem)
        {
            print $code_start;
            print $view->CurrentItem->text;
            print $code_end;

        }
            
    }

    public function RenderGridBody($view, $columns = 2)
    {
        $id = 1; //($view->Page * $view->Limit) - $view->Limit + 1;
        $counter = 1;
        $col = 12/$columns;
        $length = sizeof($view->Items);
        
        foreach ($view->Items as $item)
        {
            if($counter == 1)
            {
                print '<div class="row">';
            }

            print '<div class="col-sm-'.$col.' col-md-'.$col.'">';
            print '<div class="panel text-center">';
                       
            foreach ($view->Columns as $column)
            {
                if ($column->Visible)
                {
                    $column->Render($view,$item);
                }
            }
            
            //$this->RenderRowMenu($view, $item);
            //print '<b><a href="'.$view->CtrlName.'/'.METHOD_PARENT.'/'.$item->GetId().'">'.$item->GetTitle().'</a></b>';
            print '</div>';
            print '</div>';
            
            if($counter == $columns || $id == $length)
            {
                print '</div>';
                $counter = 0;
            }

            $counter++;
            $id++;
        }
        
    }


    public function RenderTablePagination($view,$with_ctrl = false)
    {
        if($view->Pages > 1)
        {
            //print 'Pages:'.$view->Pages;
            $start  = $this->Page - 3;
            $end    = $this->Page + 3;   
            if($start < 1)              { $start = 1; $end = 7; }
            if($end > $view->Pages)     { $start = $view->Pages - 6; $end = $view->Pages;}
            if($start < 1)
                $start = 1;
            
            // url z kontrollerem
            if($with_ctrl)
            {
                $url = $view->CtrlName.'/'.METHOD_PAGE;
            }else{
                $url = METHOD_PAGE;
            }
            
            print '<ul class="pagination">';
            for ($i = $start; $i < $end + 1 ; $i++)
            {
                if ($view->Page == $i)
                {
                    print '<li class="active"><a href="'.$url.'-'. $i.'">' . $i . '</a></li>';
                }
                else
                {
                    print '<li><a href="'.$url.'-'.$i.'">' . $i . '</a></li>';
                }
            }
            print '</ul>';
        }
    }

    public function RenderAsSelect($items, $id, $label, $name, $submit=false)
    {
        print '<div class="form-group">';
        print '<label class="control-label">' . $label . '</label>';
        print '<select id="'.$name.'" class="form-control" name="'.$name.'"';
        if($submit)
        {
            print 'onchange="this.form.submit()"';
        }
        print '>';

        foreach ($items as $item)
        {
            if ($item->GetId() == $id)
            {
                print '<option selected value="' . $item->GetId() . '">' . $item->GetName() . '</option>';
            }
            else
            {
                print '<option value="' . $item->GetId() . '">' . $item->GetName() . '</option>';
            }
        }

        print '</select>';
        print '</div>';
    }

    public function RenderSelectValue($items,$id)
    {
        $str = '';
        foreach ($items as $item)
        {
            if($item->GetId() == $id)
            {
                $str .= $item->GetName() .'<br>';
            }
        }
        
        return $str;
    }
         
    public function RenderAsCheckbox($items, $ids, $name)
    {
        //print '<div class="form-group">';
        //print '<label class="control-label">' . $label . '</label>';
       
        foreach ($items as $item)
        {
            print '<div class="checkbox"><label>';
            $checked = false;
            
            if(isset($ids))
            {
                foreach($ids as $id)
                {
                   if($item->GetId() == $id)
                    {
                        $checked = true;
                        break;
                    }
                }
            }
            
            if ($checked)
            {
                print '<input checked type="checkbox" value="'.$item->GetId().'" name="'.$name.'[]">';
            }
            else
            {
                print '<input type="checkbox" value="'.$item->GetId().'" name="'.$name.'[]">';
            }
             
            print  $item->GetName().'</label></div>';
        }

    }
   
        
    public function RenderAsHiddenArray($items, $name)
    {
        foreach ($items as $item)
        {
            print '<input type="hidden" value="'.$item.'" name="'.$name.'[]">';
        }
    }
     
    public function RenderCheckboxValue($items, $ids)
    {
        $str = '';
        foreach ($items as $item)
        {
            if(isset($ids))
            {
                foreach($ids as $id)
                {
                   if($item->GetId() == $id)
                    {
                        $str .= $item->GetName().'<br>';
                        break;
                    }
                }
            }
            
        }
        
        return $str;

    }
        
    public function RenderLanguages()
    {
        $items = $this->GetLangs();
        $this->RenderAsSelect($items,Session::GetLang(),'',IDLANG,true);
    }

    // render tree z tree
    public function RenderTreeAsSelect($items,$id, $label,$name, $level = 0) 
    {
        if($level == 0)
        {
            print '<div class="form-group">';
            print '<label class="control-label">'.$label.'</label>';
            print '<select class="form-control" id="'.$name.'" name="'.$name.'" >';
        }

        foreach ($items as $item) 
        { 

            if ($item->GetId() == $id)
                print '<option value="'.$item->GetId().'" selected>'.str_repeat(' - ', $level).$item->GetName().'</option>';
            else
                print '<option value="'.$item->GetId().'">'.str_repeat(' - ', $level).$item->GetName().'</option>';
            
            $level++;
            $this->RenderTreeAsSelect ($item->items,$id,$label,$name, $level);
            $level--;
        }
    
        if($level == 0)
        {
            print '</select>';
            print '</div>';
        }
    
    }

    // render drzewa z danych drzewiastych
    
    private function RenderMenu($menu)
    {
        //print_r($menu);
        
        $this->Model->GetMenuItems($menu->id_menu,$items);
        
        //print_r($items);
        //print '<a id="mobile-menu-button" href="#"><i class="mt-icon-menu"></i></a>';
        //print '<ul>';
        $this->RenderMenuItems($items);
        //print '</ul>';
       //print_r($menu);
      
      
    
    }
    
    public function RenderMenuItems($items, $link = '', $level = 0)
    {
        if($level == 0)
        {
            print '<a id="mobile-menu-button" href="#"><i class="mt-icon-menu"></i></a>';
            print '<ul class="menu1 clearfix" id="menu">';
        }else{
        print '<ul>';
        }
        
        $level++;
        foreach( $items as $item )
        {
            if($item->murl)
                $url = $item->murl;
            else
                $url = $item->url_address;
            
            if($item->items == NULL)
            {
                print '<li>';
                print '<a href="'.$url.'">'.$item->name.'</a>';   

            }else{

                print '<li class="dropdown">';
                print '<a class="dropdown-toggle" href="'.$url.'">'.$item->name.'</a>';   
            }
            
            $this->RenderMenuItems($item->items,$link.'/'.$item->name, $level);
            print '</li>';
            
        }
        
        print '</ul>';
             
    }
    
    private function RenderBlock($region)
    {
        /*
         *część odpowiedzialna za edycję w miejscu
        ?>
        <script>
            function makeEditable(div)
            {
                div.style.border = "1px solid #000";
                div.style.padding = "10px";
                div.contentEditable = true;
                
            }
            function makeOver(div)
            {
                div.style.border = "2px dashed #000";
                div.style.padding = "5px";
                div.style.margin = "5px";
            }

            function makeOut(div)
            {
                div.style.border = "0px";
                div.style.padding = "0px";
                div.style.margin = "0px";
            }
        </script>
        
        <?php
        */
        //print '<div name="'.$region.'" class="block" ondblclick="makeEditable(this)" onmouseover="makeOver(this)" onmouseout="makeOut(this)" onblur="makeReadOnly(this)">';
        //if($this->Model)
        //{
            $blocks = $this->Model->GetBlocks($region);
            if($blocks)
            {
                foreach($blocks as $block)
                {
                    print $block->text;
                }   
            }
        //}
        //print '</div>';
    }

    public function RenderRegion($region, $printName = false)
    {
        if ($printName)
        {
            print '<div class="panel">';
            print '<div class="text-center">['.$region.']</div>';
        }
               
        $menus = $this->Model->GetMenus($region);
        
        if($menus)
        {
            foreach($menus as $menu)
            {
                $this->RenderMenu($menu);        
            }
            
        } 
              
        print $this->RenderBlock($region);
        
        if ($printName)
        {
            print '</div>';
        }
    }
    
    private function RenderPage($template)
    {
        include TEMPLATE_HEADER_FILE;
        include TEMPLATE_FOLDER.'/'.$template;
        include TEMPLATE_FOOTER_FILE;
    }
    
    private function RenderContent($template)
    {
        include TEMPLATE_FOLDER.'/'.$template;
    }

    public function Render($template, $content = false)
    {   
        if(empty($template))
            new myException('TEMPLATE NOT SET',get_class($this));
        
        $ext = pathinfo($template, PATHINFO_EXTENSION);
        
        if($ext)
        {
            $template = $template;    
        }else{
            $template = $template.'.html';    
        }
        
        if ($this->IsTemplateExists($template))
        {
            if($content)
                $this->RenderContent($template);
            else
                $this->RenderPage($template);
        
        }else{
             
             new myException('FILE NOT EXISTS', $template);
        }
    }

}
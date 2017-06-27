<?php

// klasa Column definicja właściwości kolumn w listingu danych

class ColumnActive extends Column
{

    public $Statuses;

    public function __construct($name, $fieldname, $statuses, $visible = true)
    {
        $this->Name = $name;
        $this->FieldName = $fieldname;
        $this->Visible = $visible;
        $this->Statuses = $statuses;
    }

    public function Render($view,$item)
    {
        $name = $this->FieldName;

        foreach ($this->Statuses as $status)
        {
            if ($status->id_active == $item->$name)
            {
                if($status->active)
                    print '<input disabled class="bootstrap-switch-small1" name=my-check type=checkbox checked>';
                else
                    print '<input disabled name=my-check type=checkbox>';
                
                //print '<script>$("[name=\'my-check\']").bootstrapSwitch();</script>';
            }
        }
    }

}

class ColumnLink extends Column
{
    public function Render($view,$item)
    {
        $name = $this->FieldName;
        print '<a href="'.$view->CtrlName.'/'.METHOD_EDIT.'/'.$item->GetId().'" > ' . $item->$name . '</a>';
    }
}


class ColumnPreview extends Column
{
    public function Render($view,$item)
    {
        $name = $this->FieldName;
        print '<a href="'.$view->CtrlName.'/'.METHOD_PREVIEW.'/'.$item->GetId().'" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>';
    }
}

class ColumnUrl extends Column
{
    public function Render($view,$item)
    {
        $name = $this->FieldName;
        print '<a target="_blank" href="'.SITE_URL.'/'.$item->$name.'" >'.$item->$name.'</a>';
    }
}

class ColumnUrlAddress extends Column
{
    public function __construct($name, $fieldname, $fieldtitle,  $visible = true)
    {
        $this->Name = $name;
        $this->FieldName = $fieldname;
        $this->FieldTitle = $fieldtitle;
        $this->Visible = $visible;
    }
    
    
    public function Render($view,$item)
    {
        $name = $this->FieldName;
        $title = $this->FieldTitle;
        print '<h2><a href="'.SITE_URL.'/'.$item->$name.'" >'.$item->$title.'</a></h2>';
    }
}



class ColumnIcon extends Column
{
    
    public function __construct($name, $fieldname, $visible = true)
    {
        parent::__construct($name,$fieldname,$visible);
        $this->Name = $name;
        $this->FieldName = $fieldname;
        $this->Visible = $visible;
    }

    
    public function Render($view,$item)
    {
        $name = $this->FieldName;
        print '<a href="'.$view->CtrlName.'/'.METHOD_PARENT.'/'.$item->GetId().'" ><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span></a>';
    }
}


class ColumnImage extends Column
{
    private $Widght;
    private $Height;
    
    public function __construct($name, $fieldname, $width = 50 ,$height = 50,  $visible = true)
    {
        $this->Name = $name;
        $this->FieldName = $fieldname;
        $this->Visible = $visible;
        $this->Width = $width;
        $this->Height = $height;
    }
    
    public function Render($view,$item)
    {
        $name = $this->FieldName;
        $image = Settings::$ImagesFolder.$item->$name;

        if(empty($item->$name))
            $image = DEFAULT_IMAGE;
        
        print '<a href="" data-toggle="modal" data-target="#myModal" >';
        
        if(file_exists($image))
        {
            print '<img onclick="loadImage(this)" src ='.$image.' class="img img-circle" width='.$this->Width.' height='.$this->Height.'>';
        
        }else{
            print '<img onclick="loadImage(this)" src ='.IMAGE_DIR.'/'.DEFAULT_IMAGE.' class="img img-circle" width='.$this->Width.' height='.$this->Height.'>' ;
        }
         print '</a>';   
    }

}

class ColumnAvatar extends Column
{
    public function Render($view,$item)
    {
        $name = $this->FieldName;
              
        $avatar = AVATAR_DIR.'/'.$item->$name;
        
        print '<a href="" data-toggle="modal" data-target="#myModal" >';
        if(file_exists($avatar))
            print '<img onclick="loadImage(this)" src ='.$avatar.' class="img img-circle" width=50 height=50>';
        else
            print '<img onclick="loadImage(this)" src ='.IMAGE_DIR.'/'.DEFAULT_IMAGE.' class="img img-circle" width=50 height=50>' ;
            
        print '</a>';   
    }

}

class ColumnText extends Column
{

    public function Render($view,$item)
    {
        $name = $this->FieldName;
        print $item->$name ;
    }

}

abstract class Column extends Base
{

    public $Name;               // Nazwa columny (tytuł)
    public $FieldName;          // Nazwa pola
    public $Visible = true;

    public function __construct($name, $fieldname, $visible = true)
    {
        //parent::__construct(); // gdybyśmy chcieli printować tłumaczenia to trzeba włączyć żeby konstrował bazową
        $this->Name = $name;
        $this->FieldName = $fieldname;
        $this->Visible = $visible;
    }

}

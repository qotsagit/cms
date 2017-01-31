<?php

class fileModel extends Model
{

    public $Folder = '../templates';
    public $Files;
    public $Count = 0;

    public $id;
    public $id_file;
    public $name; 
    public $size;
    public $path;
    public $content;
    public $old_name;

    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id;
    }
    
    public function GetName()
    {
        return $this->name;
    }

    public function GetImage()
    {
        return DEFAULT_IMAGE;
    }

    // parent item from database
    public function GetParent()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
    
    public function CountAll()
    {
        return $this->Count();
    }
    
    public function Count()
    {
        $this->Lists();
        return $this->Count;
    }

    function Human_filesize($bytes, $decimals = 2) 
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    public function NewFileModel($id, $filename)
    {
        $file = new fileModel();
        $file->id = $id;
        $file->id_file = $id;
        $file->name = $filename;
        $file->path = $this->Folder.'/'.$filename;

        $file->size = filesize($this->Folder.'/'.$filename);
        return $file;
    }

    public function cmp($a, $b)
    {
        return strcmp($a->name, $b->name);
    } 

    public function GetById($id)
    {
        $this->Lists();
        return $this->Find($id,'id_file');
    }

    public function GetByName($id)
    {
        $this->Lists();
        return $this->Find($id,'name');
    }
    
    public function Update()
    {    
        file_put_contents($this->Folder.'/'.$this->name,$this->content);
    }

    public function Insert()
    {
        file_put_contents($this->Folder.'/'.$this->name,$this->content);
    }

    public function WriteFile()
    {
        //$filename = $this->
        //fopen()
    }

    public function Find($id,$field)
    {
        foreach ($this->Files as $file)
        {
            if($id == $file->$field)
            {
                $file->content = file_get_contents($file->path);
                return $file;
            }
        }
    }
    
    public function All()
    {
        return $this->Lists();    
    }
    
    public function Lists()
    {
        unset($this->Files);
        $dh  = opendir($this->Folder);
        $this->Count = 0;
        
        if($dh)
        {
            while (false !== ($filename = readdir($dh))) 
            {
                $path = $this->Folder.'/'.$filename;
                if(!is_dir($path))
                {
                    $this->Count++;
                    $this->Files[] = $this->NewFileModel($this->Count,$filename);
                }
            }
        }

       //usort($files , $this->cmp());
        
        return $this->Files;
    }
}

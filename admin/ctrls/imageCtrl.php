<?php

/**
 * imageCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/imageModel.php';
include 'models/activeModel.php';
include 'views/imageView.php';


class imageCtrl extends Ctrl
{

    private $ImageDir = IMAGE_DIR;


    public function __construct()
    {
        parent::__construct();

        $this->View = new imageView();

        // potrzebne przy listingu itp..
        $items = new activeModel();
        
        $this->View->ViewTitle = $this->Msg('_IMAGE_', 'Image');
        $this->View->CtrlName = CTRL_IMAGE;
        
        $this->View->Statuses = $items->All();

        $this->Model = new imageModel();
        $this->Validator = new Validator();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->Name = new Input();
        $this->View->Img = new Input();
        $this->View->Position = new Input();
    }

    private function InitRequired()
    {
        
    }

    private function InitValidatorFields()
    {
        
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->Name->Value = $this->View->Img->Value;
        //$this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
    }

    public function Upload()
    {
        $this->UploadImage();
        $this->ReadForm();
        $this->Insert();
        $this->Resize();
        
        print $this->ImageDir.'/mini/'.$this->View->Img->Value;
    }
    
    public function Resize()
    {
        $ImageFileName = $this->View->Img->Value;
        
        $imageResizeObj = new imageLib(Settings::$ImagesFolder.$ImageFileName);
        foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues)
        {            
            $imageResizeObj -> resizeImage($ImgSizeValues['width'], $ImgSizeValues['height'], 'crop-t', true);
            $imageResizeObj -> saveImage(Settings::$ImagesFolder.'/'.$ImgSizeValues['folder'].'/'.$ImageFileName, $ImgSizeValues['quality']);
            $imageResizeObj -> reset();           
        }
        
    }
        
    public function UploadImage()
    {
        
        if(isset($_FILES['image']['tmp_name'])) // taka konstrukcja powoduje brak warningów
        {
            $image = $_FILES['image']['tmp_name'];
            if($image)
            {
                if (!$this->DirectoryExists($this->ImageDir)) 
                {
                    if (!$this->DirectoryCreate($this->ImageDir))
                    {
                        return false; 
                    }
                }
                
                
                $file = $_FILES['image']['name'];
                $extension = strrchr($file, '.');
                $extension = strtolower($extension);
                
                $new = $this->RandomString(32).$extension;
                $target_path = $this->ImageDir .'/'.$new;
                $this->View->Img->Value = $new; 
                
                if ( move_uploaded_file( $image, $target_path ) )
                {
                    return true;
                }
                else 
                {
                    return false;
                }
            }
        
        }else{
            
            return false;
        }
    }
    
    public function Insert()
    {
        //$this->Model->id_lang = $this->View->IdLang->Value;
        $this->Model->name = $this->View->Name->Value;
        $this->Model->img = $this->View->Img->Value;
        
        $this->Model->Insert();
    
    }
    
    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_image;
            $this->View->Name->Value = $item->name;
            $this->View->Img = $item->img;
            
            return true;
        }

        return false;
    }

    public function DeleteConfirm()
    {
        $this->ReadForm();
        $this->Model->id = $this->View->Id->Value;
        $this->Model->Delete();
        $this->Listing();
    }
   
    /*
    public function FormAdd()
    {
        $items = new langModel();
        $this->View->Languages = $items->All();

        $items = new roleModel();
        $this->View->Roles = $items->All();

        $this->View->Title = $this->Msg('_NEW_','New') ;

        $this->View->Render('user/add');
    }

    public function FormEdit()
    {
        $items = new langModel();
        $this->View->Languages = $items->All();

        $items = new roleModel();
        $this->View->Roles = $items->All();

        $this->View->Title = $this->Msg('_EDIT_','Edit') ;
        
        if ($this->ReadDatabase())
        {
    
            $this->View->Render('user/add');
        
        }else{
        
             new myException('DATABASE ERROR');
        }
    }
    */
    public function Index()
    {
        switch($this->Method)
        {
            case METHOD_UPLOAD: $this->Upload();    break;
            default:            $this->Listing();   break;
        }
    }
    
    public function Listing()
    {
        $this->View->SetColumns();
        $this->View->SetModel($this->Model);
        $this->View->SetItems($this->Model);
        $this->View->Render('imageView');
    }
    
}

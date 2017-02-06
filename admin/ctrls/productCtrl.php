<?php
/**
 * productCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'views/productView.php';
include 'models/pageModel.php';
include 'models/imageModel.php';
//include 'models/fileModel.php';
include 'models/langModel.php';
include 'models/templateModel.php';
include 'models/categoryModel.php';
include 'models/activeModel.php';
include 'models/statusExtraModel.php';
include 'models/contentTypeModel.php';
include '../libs/fileuploader.php';

class productCtrl extends Ctrl 
{
    
    private $FileUploader = NULL;
    private $ImageModel = NULL;
    
    public function __construct()
    {
        parent::__construct();
        $this->View = new pageView();
        
        $items = new activeModel();
        $this->View->Statuses = $items->All();
                
        $this->View->ViewTitle = $this->Msg('_PRODUCTS_', 'Products');
        $this->View->CtrlName = CTRL_PRODUCT;
        $this->Model = new pageModel();
        $this->Model->content_type = CONTENT_PRODUCT;
        
        $this->Validator = new Validator();
        
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
        
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdPage = new Input();
        $this->View->IdParent = new Input();
        $this->View->IdLang = new Input();
        $this->View->IdCategory = new Input();
        $this->View->IdLang->Value = Session::GetLang();
        $this->View->Title = new Input();
        $this->View->Image = new Input();
        $this->View->Image->Value = IMAGES_URL.DEFAULT_IMAGE;
        $this->View->Text = new Input();
        $this->View->Url = new Input();
        $this->View->UrlAddress = new Input();
        $this->View->Template = new Input();
        $this->View->Active = new Input();
        $this->View->StatusExtra = new Input();
        $this->View->ContentType = new Input();
        $this->View->Price = new Input();
        $this->View->Position = new Input();
        
        $this->View->MetaTitle = new Input();
        $this->View->MetaDescription = new Input();
        
        $this->View->Active->Value = STATUS_ACTIVE;
        $this->View->StatusExtra->Value = STATUS_EXTRA_NOT_ACTIVE;
        $this->View->ContentType->Value = CONTENT_PRODUCT;
    }

    private function InitRequired()
    {
        $this->View->Title->SetRequired(true);
        //$this->View->Text->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Title);
        //$this->Validator->Add($this->View->Text);   
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdPage->Value = filter_input(INPUT_POST, IDPAGE);
        $this->View->IdParent->Value = filter_input(INPUT_POST, IDPARENT);
        $this->View->IdCategory->Value = filter_input(INPUT_POST, IDCATEGORY);
        $this->View->Title->Value = filter_input(INPUT_POST, PAGE_TITLE);
        $this->View->Text->Value = filter_input(INPUT_POST, PAGE_TEXT);
        $this->View->Url->Value = filter_input(INPUT_POST, PAGE_URL);
        $this->View->IdLang->Value = filter_input(INPUT_POST, PAGE_ID_LANG);
        $this->View->Active->Value = filter_input(INPUT_POST, PAGE_STATUS);
        $this->View->StatusExtra->Value = filter_input(INPUT_POST, PAGE_STATUS_EXTRA);
        //$this->View->ContentType->Value = filter_input(INPUT_POST, PAGE_CONTENT_TYPE);
        $this->View->Price->Value = filter_input(INPUT_POST, PAGE_PRICE);
        
        $this->View->MetaTitle->Value = filter_input(INPUT_POST, PAGE_META_TITLE);
        $this->View->MetaDescription->Value = filter_input(INPUT_POST, PAGE_META_DESCRIPTION);
        
        $this->View->Template->Value = filter_input(INPUT_POST, PAGE_TEMPLATE);
        $this->View->Position->Value = filter_input(INPUT_POST, PAGE_POSITION);
        
        
        if ((isset($_FILES['image']['name']) AND count($_FILES['image']['name'])) OR (isset($_FILES['file']['name']) AND count($_FILES['file']['name'])))
        {
            $this->FileUploader = new FileUploader();
            $this->ImageModel = new imageModel();
        }
                      
        if (isset($_FILES['img']['name']) AND count($_FILES['img']['name']))
        {
            if ($this->FileUploader == NULL)
            {
                
                $this->FileUploader = new FileUploader();
                
            }
            
            if ($this->ImageModel == NULL)
            {
                
                $this->ImageModel = new imageModel();
                
            }

            
            $this->FileUploader->UploadOneImage($_FILES['img']);
                
        }
    }
    
    public function Validate()
    {
        $WalidacjaPol = parent::Validate(); //return $this->Validator->Validate();
        
        $Walidacja = $WalidacjaPol;
        
        if ($Walidacja){
            $this->View->FileUploadError = 'TRU';
            
        } else {
            $this->View->FileUploadError = 'FALS';
            
        }
        
        $WalidacjaUpload = $this->FileUploader->NoError();
            
                
        if($Walidacja AND $WalidacjaUpload!==TRUE){
            
            $this->View->FileUploadError = $WalidacjaUpload;
            
            //return $WalidacjaUpload;
                
        } 
        
        return TRUE;
        
    }
    
    public function ReadDatabase()
    {
        $item = $this->Model->Get($this->View->_Id);

        if($item)
        {
            $this->View->Id->Value = $item->id_page;
            $this->View->IdPage->Value = $item->id_page;
            $this->View->IdParent->Value = $item->id_parent;
            $this->View->IdCategory->Value = $item->id_category;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->Title->Value = $item->title;
            $this->View->Text->Value =  $item->text;
            $this->View->Url->Value = $item->url;
            $this->View->UrlAddress->Value = $item->url_address;
            $templateModel = new templateModel();
            $this->View->Template->Value = $templateModel->GetByName($item->template)->id;
            $this->View->ContentType->Value = $item->content_type;
            $this->View->Active->Value = $item->active;
            $this->View->Price->Value = $item->price;
            $this->View->StatusExtra->Value = $item->status_extra;
            $this->View->MetaTitle->Value = $item->meta_title;
            $this->View->MetaDescription->Value = $item->meta_description;
            $this->View->Position->Value = $item->position;
            $this->View->Image->Value = $item->img;
            
            return true;
        }

        return false;
    }
   
    public function Insert()
    {
        $this->Model->id_user = Session::GetUser()->id_user;
        $this->Model->id_page = $this->View->IdPage->Value;
        $this->Model->id_parent = $this->View->IdParent->Value;
        $this->Model->id_lang = $this->View->IdLang->Value;
        $this->Model->id_category = $this->View->IdCategory->Value;
        $this->Model->title = $this->View->Title->Value;
        $this->Model->text = $this->View->Text->Value;
        $this->Model->url = $this->View->Url->Value;
        $this->Model->content_type = $this->View->ContentType->Value;
        $this->Model->active = $this->View->Active->Value;
        $this->Model->status_extra = $this->View->StatusExtra->Value;
        $this->Model->price = $this->View->Price->Value;
        $templateModel = new templateModel();
        $this->Model->template = $templateModel->GetById($this->View->Template->Value)->name;
        
        $this->Model->meta_title = $this->View->MetaTitle->Value;
        $this->Model->meta_description = $this->View->MetaDescription->Value;
        $this->Model->position = $this->View->Position->Value;
        

        $url = NULL;
        $this->Model->Url($this->Model->id_parent,$url);
        if($url == NULL)
            $this->Model->url_address = $this->TransliterateStringToUrl($this->View->Title->Value);
        else
            $this->Model->url_address = $this->TransliterateStringToUrl($url.' '.$this->View->Title->Value);
        
        if ($this->View->IdPage->Value > 0)
        {
            $this->Model->Update();
            
            $this->ImageModel->UpdateImages($this->View->IdPage->Value, $this->FileUploader->ImagesUploaded);
            
            $this->ImageModel->UpdateOneImage($this->View->IdPage->Value, $this->FileUploader->OneImageUploaded);

            
            //$this->FileModel->Update($this->View->IdPage->Value, $this->FileUploader->FilesUploaded);
            
        }
        else
        {
            $this->Model->Insert();
            
            $this->ImageModel->InsertImages($this->FileUploader->ImagesUploaded, $this->FileUploader->OneImageUploaded);
            
            //$this->FileModel->Insert($this->FileUploader->FilesUploaded);
        }
    }

    private function InitModels()
    {
        $items = new categoryModel();
        $this->View->Categories = $items->All();
        $items->AddItem($this->Msg('_CHOOSE_','Choose'),$this->View->Categories);
        
        $items = new activeModel();
        $this->View->Statuses = $items->All();
        
        $items = new statusExtraModel();
        $this->View->StatusesExtra = $items->All();
        
        $items = new contentTypeModel();
        $this->View->ContentTypes = $items->All();
        
        $items = new langModel();
        $this->View->Languages = $items->All();
        
        $items = new templateModel();
        $this->View->Templates = $items->All();
    }
    
    private function Form()
    {
        $this->InitModels();
        
        Settings::$CKEditorUse = true;
        Settings::$JqueryFileUploader=TRUE;
        
        $this->View->ViewTitle = $this->Msg('_NEW_','New');
        //strony drzewo
        $this->Model->Tree(0,0,Session::GetLang(),$this->View->Pages);
        $this->Model->AddParent($this->Msg('_PARENT_PAGE_','Parent Page'),$this->View->Pages);
        
 		$this->View->IdParent->Value = Session::GetIdParent();
        $this->View->IdLang->Value = Session::GetLang();
        $this->View->Render('page/add');
    }
    
    
    public function FormAdd()
    {
       $this->Form();
    }

    public function FormAddNews()
    {
        $this->View->ContentType->Value = CONTENT_NEWS;
        $this->Form();
    }
    
    
    public function FormEdit()
    {
        $this->InitModels();
        
        Settings::$CKEditorUse = true;
        Settings::$JqueryFileUploader = TRUE;
        
        if ($this->ReadDatabase())
        {
            
            $this->View->ViewTitle = $this->Msg('_EDIT_','Edit').' - '.$this->View->Title->Value;
            $this->ImageModel = new imageModel();
            //strony drzewo

            $this->Model->Tree(0,$this->View->IdPage->Value,$this->View->IdLang->Value , $this->View->Pages);
            $this->Model->AddParent($this->Msg('_PARENT_PAGE_','Parent Page'),$this->View->Pages);
            
            //tablica musi być odwrócona dla skryptu jquery.filer aby było od najwyższej pozycji do najniższej
            $this->View->ImagesInPage =  $this->ImageModel->GetImages($this->View->_Id);
            $this->View->Image->Value = $this->ImageModel->GetOneImage($this->View->_Id, $WithUrl = TRUE);
            //$this->View->IdLang->Value = Session::GetLang();
            
            //$this->PrintArray($this->View->ImagesInPage);
            
            $this->View->Render('page/add');
            
        }else{
        
            $this->View->Render('error');
        }
    }
    
    public function FormCopy()
    {
        if ($this->ReadDatabase())
        {
            $items = new langModel();
            $this->View->Languages = $items->All();
            $this->Model->Tree(0,0,$this->View->IdLang->Value ,$this->View->Pages);
            $this->Model->AddParent($this->Msg('_PARENT_PAGE_','Parent Page'),$this->View->Pages);
            $this->View->Render('page/copy');
        
        }else{
        
            $this->View->Render('error');
        }
    }
    
    public function CopyConfirm()
    {
        $this->ReadForm();
        $this->Model->id = $this->View->Id->Value;
        $this->Model->id_lang = $this->View->IdLang->Value;
        $this->Model->id_parent = $this->View->IdParent->Value;
        $this->Model->content_type = CONTENT_PRODUCT; 
        $this->Model->Copy();
        
        $this->ImageModel = new imageModel();
        $this->ImageModel->id = $this->View->Id->Value;
        $this->ImageModel->id_page = $this->Model->LastInsertId();
        $this->ImageModel->Copy();
                
        
        $this->Listing();
    }
     
    //ajax listuje strony jako opcje
    public function RenderOptionsTree($items,$id, $level = 0) 
    {
       
        foreach ($items as $item) 
        { 

            if ($item->GetId() == $id)
                print '<option value="'.$item->GetId().'" selected>'.str_repeat(' - ', $level).$item->GetName().'</option>';
            else
                print '<option value="'.$item->GetId().'">'.str_repeat(' - ', $level).$item->GetName().'</option>';
            
            $level++;
            $this->RenderOptionsTree ($item->items,$id, $level);
            $level--;
        }
    
    }
    
    public function Options()
    {
        $id_lang = $_GET['page_id_lang'];
        $id_page = $_GET['page_id_page'];
        $id_parent = $_GET['id_parent'];
                
        $this->Model->Tree(0,$id_page, $id_lang,$items);
        $this->Model->AddParent($this->Msg('_PARENT_PAGE_','Parent Page'),$items);
        
        $this->RenderOptionsTree($items,$id_parent);
        
        exit;
    }
    
    
}	   
	   
?>

<?php

/**
 * categoryCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */


include 'models/categoryModel.php';
include 'views/categoryView.php';

class categoryCtrl extends Ctrl
{    

    public function __construct()
    {
        parent::__construct();
        $this->Model = new categoryModel();
        $this->View = new categoryView($this);
        $this->View->ViewTitle = $this->Msg('_CATEGORIES_','Categories');
        $this->View->CtrlName = CTRL_CATEGORY;
        
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdCategory = new Input();
        $this->View->IdParent = new Input();
        $this->View->Name = new Input();
    }

    private function InitRequired()
    {
        $this->View->Name->SetRequired(true);
    }

    private function InitValidatorFields()
    {
         $this->Validator->Add($this->View->Name);
    }

    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdCategory->Value = filter_input(INPUT_POST, CATEGORY_IDCATEGORY);
        $this->View->IdParent->Value = filter_input(INPUT_POST, IDPARENT);
        $this->View->Name->Value = filter_input(INPUT_POST, CATEGORY_NAME);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_category;
            $this->View->IdCategory->Value = $item->id_category;
            $this->View->IdParent->Value = $item->id_parent;
            $this->View->Name->Value = $item->name;
            
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_category = $this->View->IdCategory->Value;
        $this->Model->id_lang = Session::GetLang();
        $this->Model->id_parent = $this->View->IdParent->Value;
        $this->Model->name = $this->View->Name->Value;
        
        if ($this->View->IdCategory->Value > 0)
        {
            $this->Model->Update();
        }
        else
        {
            $this->Model->Insert();
        }
    }
    
    public function FormAdd()
    {
        $this->View->IdParent->Value = Session::GetIdParent();
        $this->View->Render('category/add');
    }

    public function FormEdit()
    {

        if ($this->ReadDatabase())
        {
            $this->View->Render('category/add');
        
        }else{
        
            new myException('DATABASE ERROR');
        }
    }

}

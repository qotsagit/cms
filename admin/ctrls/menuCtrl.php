<?php

/**
 * menuCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/menuModel.php';
include 'models/langModel.php';
include 'models/activeModel.php';
include 'models/pageModel.php';
include 'views/menuView.php';

class menuCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new menuView();

        // potrzebne przy listingu itp..
        $items = new activeModel();
        $this->View->Statuses = $items->All();
        $this->View->ViewTitle = $this->Msg('_MENU_', 'Menu');
        $this->View->CtrlName = CTRL_MENU;
        $this->View->SetColumns();

        $this->Model = new menuModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdMenu = new Input();
        $this->View->IdParent = new Input();
        $this->View->IdLang = new Input();
        $this->View->IdRegion = new Input();
        $this->View->IdPage = new Input();
        $this->View->Name = new Input();
        $this->View->Url = new Input();
        $this->View->Active = new Input();
        $this->View->Position = new Input();
        
        $this->View->Position->Value = 0;
        $this->View->IdRegion->Value = DEFAULT_ID;
    }

    private function InitRequired()
    {
        $this->View->Name->SetRequired(true);
        //$this->View->Url->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Name);
        //$this->Validator->Add($this->View->Url);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdMenu->Value = filter_input(INPUT_POST, IDMENU);
        $this->View->IdParent->Value = filter_input(INPUT_POST, IDPARENT);
        $this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
        $this->View->IdRegion->Value = filter_input(INPUT_POST, IDREGION);
        $this->View->IdPage->Value = filter_input(INPUT_POST, IDPAGE);
        $this->View->Name->Value = filter_input(INPUT_POST, MENU_NAME);
        $this->View->Url->Value = filter_input(INPUT_POST, MENU_URL);
        $this->View->Active->Value = filter_input(INPUT_POST, MENU_STATUS);
        $this->View->Position->Value = filter_input(INPUT_POST, MENU_POSITION);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_menu;
            $this->View->IdMenu->Value = $item->id_menu;
            $this->View->IdParent->Value = $item->id_parent;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->IdRegion->Value = $item->id_region;
            $this->View->IdPage->Value = $item->id_page;
            $this->View->Name->Value = $item->name;
            $this->View->Url->Value = $item->url;
            $this->View->Active->Value = $item->active;
            $this->View->Position->Value = $item->position;
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_menu = $this->View->IdMenu->Value;
        $this->Model->id_parent = $this->View->IdParent->Value;
        $this->Model->id_lang = Session::GetLang(); //$this->View->IdLang->Value;
        $this->Model->id_region = $this->View->IdRegion->Value;
        $this->Model->id_page = $this->View->IdPage->Value;
        $this->Model->name = $this->View->Name->Value;
        $this->Model->url = $this->View->Url->Value;
        $this->Model->active = $this->View->Active->Value;
        $this->Model->position = $this->View->Position->Value;

        if ($this->View->IdMenu->Value > 0)
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
        $this->View->ViewTitle = $this->Msg('_NEW_', 'New');
        
        $items = new langModel();
        $this->View->Languages = $items->All();

        $items = new regionModel();
        $this->View->Regions = $items->All();
        
        //strony drzewo
        $items = new pageModel();
        $items->Tree(0,0,Session::GetLang(),$this->View->Pages);
        $items->AddParent($this->Msg('_CHOOSE_PAGE_','Choose Page'), $this->View->Pages);
 
        $this->Model->Tree(0,0,$this->View->Menus);
        $this->Model->AddParent($this->View->Menus);
       
        $this->View->IdLang->Value = Session::GetLang();
        $this->View->IdParent->Value = Session::GetIdParent();
        $this->View->Active->Value = STATUS_ACTIVE;
        
        if($this->View->IdParent->Value > 0)
             $this->View->Render('menu/addItem');
        else
            $this->View->Render('menu/addMenu');
    }

    public function FormEdit()
    {
        $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');
       
        if ($this->ReadDatabase())
        {
            $items = new langModel();
            $this->View->Languages = $items->All();

            $items = new regionModel();
            $this->View->Regions = $items->All();

            // strony drzewo
            $items = new pageModel();
            $items->Tree(0, 0, Session::GetLang(), $this->View->Pages);
            $items->AddParent($this->Msg('_CHOOSE_PAGE_','Choose Page'), $this->View->Pages);
 
        
            $this->Model->Tree(0,$this->View->IdMenu->Value, $this->View->Menus);
            $this->Model->AddParent($this->View->Menus);
       
        
            if($this->View->IdParent->Value > 0)
                $this->View->Render('menu/addItem');
            else
                $this->View->Render('menu/addMenu');
        
        }else{
            
            $this->View->Render('error');
        
        }
    }

    
}

<?php
/**
 * blockCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/blockModel.php';
include 'models/langModel.php';
include 'models/activeModel.php';
include 'views/blockView.php';

class blockCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new blockView();

        // potrzebne przy listingu itp..
        $items = new activeModel();
        $this->View->Statuses = $items->All();
        $this->View->ViewTitle = $this->Msg('_BLOCKS_', 'Blocks');
        $this->View->CtrlName = CTRL_BLOCK;
        $this->View->SetColumns();

        $this->Model = new blockModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdBlock = new Input();
        $this->View->IdUser = new Input();
        $this->View->IdLang = new Input();
        $this->View->IdRegion = new Input();
        $this->View->Title = new Input();
        $this->View->Text = new Input();
        $this->View->Active = new Input();
        $this->View->Active->Value = STATUS_ACTIVE;
    }

    private function InitRequired()
    {
        $this->View->Title->SetRequired(true);
        $this->View->Text->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Title);
        $this->Validator->Add($this->View->Text);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdBlock->Value = filter_input(INPUT_POST, IDBLOCK);
        $this->View->IdUser->Value = filter_input(INPUT_POST, IDUSER);
        $this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
        $this->View->IdRegion->Value = filter_input(INPUT_POST, IDREGION);
        $this->View->Title->Value = filter_input(INPUT_POST, BLOCK_TITLE);
        $this->View->Text->Value = filter_input(INPUT_POST, BLOCK_TEXT);
        $this->View->Active->Value = filter_input(INPUT_POST, BLOCK_STATUS);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_block;
            $this->View->IdBlock->Value = $item->id_block;
            $this->View->IdUser->Value = $item->id_user;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->IdRegion->Value = $item->id_region;
            $this->View->Title->Value = $item->title;
            $this->View->Text->Value = htmlspecialchars($item->text);
            $this->View->Active->Value = $item->active;
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_block = $this->View->IdBlock->Value; 
        $this->Model->id_user = Session::GetUser()->id_user;
        $this->Model->id_lang = Session::GetLang(); //    $this->View->IdLang->Value;
        $this->Model->id_region = $this->View->IdRegion->Value;
        $this->Model->title = $this->View->Title->Value;
        $this->Model->text = $this->View->Text->Value;
        $this->Model->active = $this->View->Active->Value;

        if ($this->View->IdBlock->Value > 0)
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
        Settings::$CKEditorUse = true;
        
        $this->View->ViewTitle = $this->Msg('_ADD_', 'Add');
        
        $items = new langModel();
        $this->View->Languages = $items->All();

        $items = new regionModel();
        $this->View->Regions = $items->All();

        $this->View->IdLang->Value = Session::GetLang();
        $this->View->Render('block/add');
    }

    public function FormEdit()
    {
        Settings::$CKEditorUse = true;
        
        if ($this->ReadDatabase())
        {
        
            $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');
            $items = new langModel();
            $this->View->Languages = $items->All();

            $items = new regionModel();
            $this->View->Regions = $items->All();
        
            $this->View->Render('block/add');
        
        }else{

            $this->View->Render('error');
        }
    }
     
}

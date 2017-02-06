<?php
/**
 * newsletterCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/newsletterModel.php';
include 'views/newsletterView.php';

class newsletterCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new newsletterView();
        $this->View->ViewTitle = $this->Msg('_NEWSLETTER_', 'Newsletter');
        $this->View->CtrlName = CTRL_NEWSLETTER;
        $this->View->SetColumns();

        $this->Model = new newsletterModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdNewsletter = new Input();
        $this->View->StartDate = new Input();
        $this->View->Title = new Input();
        $this->View->Text = new Input();
    }

    private function InitRequired()
    {
        $this->View->Title->SetRequired(true);
        $this->View->Text->SetRequired(true);
        $this->View->StartDate->SetRequired(true);
        //$this->View->StartDate->SetDate($this->View->StartDate,$this->View->EndDate);
        
        //$this->View->EndDate->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Title);
        $this->Validator->Add($this->View->StartDate);
        $this->Validator->Add($this->View->Text);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdNewsletter->Value = filter_input(INPUT_POST, IDNEWSLETTER);
        $this->View->StartDate->Value = filter_input(INPUT_POST, NEWSLETTER_START_DATE);
        $this->View->Title->Value = filter_input(INPUT_POST, NEWSLETTER_TITLE);
        $this->View->Text->Value = filter_input(INPUT_POST, NEWSLETTER_TEXT);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_newsletter;
            $this->View->IdNewsletter->Value = $item->id_newsletter;
            $this->View->StartDate->Value = $item->start_date;
            $this->View->Title->Value = $item->title;
            $this->View->Text->Value = htmlspecialchars($item->text);

            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_newsletter = $this->View->IdNewsletter->Value;
        $this->Model->start_date =  $this->View->StartDate->Value;
        $this->Model->title = $this->View->Title->Value;
        $this->Model->text = $this->View->Text->Value;
        
        if ($this->View->IdNewsletter->Value > 0)
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
        $this->View->Render('newsletter/add');
    }

    public function FormEdit()
    {
        Settings::$CKEditorUse = true;
        $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');

        if ($this->ReadDatabase())
        {
            $this->View->Render('newsletter/add');
        
        }else{

            $this->View->Render('error');
        }
    }
    
}

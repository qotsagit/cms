<?php

/**
 * placeCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2017 maxkod.pl
 * @version    1.0
 */

include 'models/placeModel.php';
include 'views/placeView.php';

class placeCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();

        $this->View = new placeView();
        //$this->View->SetColumns();
        $this->Model = new placeModel();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdPlace = new Input();
        $this->View->Title = new Input();
        $this->View->Text = new Input();
        $this->View->Lat = new Input();
        $this->View->Lon = new Input();
        $this->View->Zoom = new Input();
        $this->View->Zoom->Value = PLACE_DEFAULT_ZOOM;
    }

    private function InitRequired()
    {
        $this->View->Title->SetRequired(true);
        $this->View->Lon->SetRequired(true);
        $this->View->Lat->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Title);
        $this->Validator->Add($this->View->Lon);
        $this->Validator->Add($this->View->Lat);
        //$this->Validator->Add($this->View->Url);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdPlace->Value = filter_input(INPUT_POST, ID);
        $this->View->Title->Value = filter_input(INPUT_POST, PLACE_TITLE);
        $this->View->Text->Value = filter_input(INPUT_POST, PLACE_TEXT);
        $this->View->Lon->Value = filter_input(INPUT_POST, PLACE_LON);
        $this->View->Lat->Value = filter_input(INPUT_POST, PLACE_LAT);
        $this->View->Zoom->Value = filter_input(INPUT_POST, PLACE_ZOOM);
    }

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_place;
            $this->View->IdPlace->Value = $item->id_place;
            $this->View->Title->Value = $item->title;
            $this->View->Text->Value = $item->text;
            $this->View->Lon->Value = $item->lon;
            $this->View->Lat->Value = $item->lat;
            $this->View->Zoom->Value = $item->zoom;
            return true;
        }

        return false;
    }

    private function SetModel()
    {
        $this->Model->id_place = $this->View->IdPlace->Value;
        $this->Model->title = $this->View->Title->Value;
        $this->Model->text = $this->View->Text->Value;
        $this->Model->lon = $this->View->Lon->Value;
        $this->Model->lat = $this->View->Lat->Value;
        $this->Model->zoom = $this->View->Zoom->Value;
    }
    
    public function Insert()
    {
        $this->SetModel();
        $this->Model->Insert();
    }
    
    public function Update()
    {
        $this->SetModel();
        $this->Model->Update();
    }
   
    public function FormAdd()
    {
        $this->View->ViewTitle = $this->Msg('_NEW_', 'New');
        $this->View->Render('place/add');
    }

    public function FormEdit()
    {
        $this->View->ViewTitle = $this->Msg('_EDIT_', 'Edit');
       
        if ($this->ReadDatabase())
        {

            $this->View->Render('place/add');
        
        }else{
            
            $this->View->Render('error');
        
        }
    }

    
}

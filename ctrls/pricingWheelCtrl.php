<?php

/**
 * pricingWheelCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/pricingWheelModel.php';
include 'views/pricingWheelView.php';

class pricingWheelCtrl extends Ctrl
{
    
    public function __construct()
    {
        parent::__construct(false);
                
        $this->Model = new pricingWheelModel();
        $this->View = new pricingWheelView();
        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
        
        //kolory
        $this->colorModel = new colorModel(); 
        $this->View->Colors = $this->colorModel->All();
        
        //koła
        $this->wheelModel = new wheelModel();
        $this->View->Wheels = $this->wheelModel->All();
        
        //koła mtb size
        $this->sizeModel = new sizeModel();
        $this->View->Sizes = $this->sizeModel->All();
        
        //hamulce
        $this->brakesModel = new brakesModel();
        $this->View->Brakes = $this->brakesModel->All();
        
        //hamulce mocowanie
        $this->mountingModel = new mountingModel();
        $this->View->Mountings = $this->mountingModel->All();
        
        //przeznaczenie MTB
        $this->purposeMTBModel = new purposeMTBModel();
        $this->View->PurposesMTB = $this->purposeMTBModel->All();
        
        //przeznaczenie Road
        $this->purposeRoadModel = new purposeRoadModel();
        $this->View->PurposesRoad = $this->purposeRoadModel->All();
        
        //opona
        $this->tireModel = new tireModel();
        $this->View->Tires =  $this->tireModel->All();
        
        //oś przód
        $this->axisFrontModel = new axisFrontModel();
        $this->View->AxisFronts = $this->axisFrontModel->All();
        
        //oś tył
        $this->axisRearModel = new axisRearModel();
        $this->View->AxisRears = $this->axisRearModel->All();
        
        //kaseta
        $this->cassetteMTBModel = new cassetteMTBModel();
        $this->View->CassettesMTB = $this->cassetteMTBModel->All();
        
        $this->cassetteRoadModel = new cassetteRoadModel();
        $this->View->CassettesRoad = $this->cassetteRoadModel->All();
        
        //uszczelniacz
        $this->sealantModel = new sealantModel();
        $this->View->Sealants = $this->sealantModel->All();
        
    }

    private function InitFormFields()
    {
        $this->View->FirstName = new Input();
        $this->View->LastName = new Input();
        $this->View->Email = new Input();
        $this->View->Phone = new Input();
        $this->View->YourWeight = new Input();
        $this->View->Budget = new Input();
        $this->View->Budget->Value = 0;
        
        $this->View->Color = new Input();
        $this->View->ExpectedWeight = new Input();
        
        //wheels
        $this->View->Wheel = new Input();
        $this->View->Size = new Input();            //mtb size
        
        //brakes - hamulce
        $this->View->Brake = new Input();
        $this->View->Mounting = new Input();
        
        //purpose
        $this->View->PurposeMTB = new Input();
        $this->View->PurposeRoad = new Input();
        
        //tire
        $this->View->Tire = new Input();
    
        //axis - oś
        $this->View->AxisFront = new Input();
        $this->View->AxisRear = new Input();
        
        //cassette - kaseta
        $this->View->CassetteMTB = new Input();
        $this->View->CassetteRoad = new Input();
        
        //sealant - uszczelniacz
        $this->View->Sealant = new Input();
        
        //dodatkowe akcesoria tesxtarea
        $this->View->Comment = new Input();
        
    }
    
    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
        //$this->View->Email->SetUniqueEmail();
        $this->View->Email->SetType(FIELD_TYPE_EMAIL);        
        $this->View->FirstName->SetRequired(true);
        $this->View->LastName->SetRequired(true);
        $this->View->Phone->SetRequired(true);
        $this->View->YourWeight->SetRequired(true);
        $this->View->ExpectedWeight->SetRequired(true);
        $this->View->Budget->SetRequired(true);
                
        $this->View->PurposeMTB->SetChecked(true);
        $this->View->PurposeRoad->SetChecked(true);
        //$this->View->City->SetRequired(true);

        //$this->View->ZipCode->SetRequired(true);
        
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
        $this->Validator->Add($this->View->FirstName);
        $this->Validator->Add($this->View->LastName);
        $this->Validator->Add($this->View->Phone);
        $this->Validator->Add($this->View->YourWeight);
        $this->Validator->Add($this->View->ExpectedWeight);
        $this->Validator->Add($this->View->Budget);
        //$this->Validator->Add($this->View->City);
        //$this->Validator->Add($this->View->ZipCode);
    }
    
    public function ReadForm()
    {
        $this->View->FirstName->Value = filter_input(INPUT_POST, PRICING_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, PRICING_LAST_NAME);
        $this->View->Email->Value = filter_input(INPUT_POST, PRICING_EMAIL);
        $this->View->Phone->Value = filter_input(INPUT_POST, PRICING_PHONE);
        $this->View->YourWeight->Value = filter_input(INPUT_POST, PRICING_YOUR_WEIGHT);
        $this->View->Budget->Value = filter_input(INPUT_POST, PRICING_BUDGET);
        $this->View->Color->Value = filter_input(INPUT_POST, PRICING_COLOR);
        $this->View->ExpectedWeight->Value = filter_input(INPUT_POST, PRICING_EXPECTED_WEIGHT);
        $this->View->Wheel->Value = filter_input(INPUT_POST, PRICING_WHEEL);
        $this->View->Size->Value = filter_input(INPUT_POST, PRICING_SIZE);
        $this->View->Brake->Value = filter_input(INPUT_POST, PRICING_BRAKE);
        $this->View->Mounting->Value = filter_input(INPUT_POST, PRICING_MOUNTING);
        
        if(isset($_POST[PRICING_PURPOSE_MTB]))
            $this->View->PurposeMTB->Value =  $_POST[PRICING_PURPOSE_MTB];
        if(isset($_POST[PRICING_PURPOSE_ROAD]))
            $this->View->PurposeRoad->Value =  $_POST[PRICING_PURPOSE_ROAD];
       
        $this->View->Tire->Value = filter_input(INPUT_POST, PRICING_TIRE);
        
        $this->View->AxisFront->Value = filter_input(INPUT_POST, PRICING_AXIS_FRONT);
        $this->View->AxisRear->Value = filter_input(INPUT_POST, PRICING_AXIS_REAR);
        
        //cassette - kaseta
        $this->View->CassetteMTB->Value = filter_input(INPUT_POST, PRICING_CASSETTE_MTB);
        $this->View->CassetteRoad->Value = filter_input(INPUT_POST, PRICING_CASSETTE_ROAD);

        //uszczelniacz
        $this->View->Sealant->Value = filter_input(INPUT_POST, PRICING_SEALANT);
        $this->View->Comment->Value = filter_input(INPUT_POST, PRICING_COMMENT);
          
        
        //dodajemy do validatora dopiero po przeczytaniu typu
        
        if($this->View->Wheel->Value == 0) //szosa
        {
            $this->Validator->Add($this->View->PurposeRoad);
        }else{
            $this->Validator->Add($this->View->PurposeMTB);
        }
        
        
    }
    
    public function Insert()
    {
        
        $this->SendEmail();
        
    }
    
    public function SendEmail()
    {
        //ob_start();
        //$this->View->Render('pricing1/preview',true);
        //$msg = ob_get_contents();
        //ob_end_clean();
                
        $email = new Email();
        $msg  = "<a href=mailto:".$this->View->Email->Value.">".$this->View->Email->Value."</a><br>";
        $msg .= $this->Msg('_FIRST_NAME_','First Name').': '. $this->View->FirstName->Value."<br>";
        $msg .= $this->Msg('_LAST_NAME_','Last Name').': '.$this->View->LastName->Value."<br>";
        $msg .= $this->Msg('_PHONE_','Phone').': '.$this->View->Phone->Value."<br>";
        $msg .= $this->Msg('_YOUR_WEIGHT_','Your Weight').': '.$this->View->YourWeight->Value."<br>";
        $msg .= $this->Msg('_BUDGET_','Budget').':'. $this->View->Budget->Value."<br>";
        $msg .= $this->Msg('_COLOR_','Color').':'.$this->View->RenderSelectValue($this->View->Colors, $this->View->Color->Value);
        $msg .= $this->Msg('_EXPECTED_WEIGHT_','Expected Weight').':'.$this->View->ExpectedWeight->Value."<br>";
        $msg .= $this->Msg('_WHEEL_','Wheel').':'.$this->View->RenderSelectValue($this->View->Wheels,$this->View->Wheel->Value);
        
        // koło
        if ($this->View->Wheel->Value == 0)
        {
            $msg.= $this->Msg('_PURPOSE_','Purpose').':<br>'.$this->View->RenderCheckboxValue($this->View->PurposesRoad,$this->View->PurposeRoad->Value);
            $msg.= $this->Msg('_TIRE_','Tire').':'.$this->View->RenderSelectValue($this->View->Tires,$this->View->Tire->Value);
            $msg.= $this->Msg('_CASSETTE_','Cassette').':'.$this->View->RenderSelectValue($this->View->CassettesRoad,$this->View->CassetteRoad->Value);
        }
        
        if($this->View->Wheel->Value == 1)  //mtb
        {
            $msg .= $this->Msg('_SIZE_','Size').':'.$this->View->RenderSelectValue($this->View->Sizes,$this->View->Size->Value)."<br>";
            $msg .= $this->Msg('_PURPOSE_','Purpose').':<br>'.$this->View->RenderCheckboxValue($this->View->PurposesMTB,$this->View->PurposeMTB->Value);
            
            //oś
            $msg .= $this->Msg('_AXIS_FRONT_','Axis Front').':'.$this->View->RenderSelectValue($this->View->AxisFronts,$this->View->AxisFront->Value);
            $msg .= $this->Msg('_AXIS_REAR_','Axis Rear').':'.$this->View->RenderSelectValue($this->View->AxisRears,$this->View->AxisRear->Value);

            $msg.= $this->Msg('_CASSETTE_','Cassette').':'.$this->View->RenderSelectValue($this->View->CassettesMTB,$this->View->CassetteMTB->Value);
        }    
                
        //hamulec
        $msg .= $this->Msg('_BRAKES_','Brakes').':'.$this->View->RenderSelectValue($this->View->Brakes,$this->View->Brake->Value);           
        
        if ($this->View->Brake->Value == 0)
        {
            $msg .= $this->Msg('_MOUNTING_','Mounting').':'.$this->View->RenderSelectValue($this->View->Mountings,$this->View->Mounting->Value);   
        }
        
        
        $msg .= $this->Msg('_SEALANT_','Sealant').':'.$this->View->RenderSelectValue($this->View->Sealants,$this->View->Sealant->Value);
        $msg .= $this->Msg('_OTHER_ITEMS_','Other items').':'.$this->View->Comment->Value;
        
        
        //print $msg;
               
        
        
        $email->Send(SMTP_TO, $this->Msg('_PRICING_','Pricing'),$msg);   
    }
    
    public function FormAdd()
    {
        $this->ReadForm();
        $this->View->Render('pricingWheel/index');       
    }
    
    public function FormPreview()
    {
        $this->View->Render('pricingWheel/preview');    
    }
        
    public function Listing()
    {
        if($this->View->Saved)
             $this->View->Render('pricingWheel/preview');
        else
            $this->View->Render('pricingWheel/index');       
    }

}

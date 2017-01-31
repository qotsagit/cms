<?php

/**
 * valuationCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/pricingModel.php';
include 'views/pricingView.php';

class pricingCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct(false);
                
        $this->Model = new pricingModel();
        $this->View = new pricingView();
        $this->InitFormFields();
        
    }

     private function InitFormFields()
    {
        $this->View->Email = new Input();
        $this->View->Password = new Input();
        $this->View->FirstName = new Input();
        $this->View->LastName = new Input();
        $this->View->City = new Input();
        $this->View->ZipCode = new Input();
        $this->View->Phone = new Input();
        
        $this->View->Domain = new Input();
    }
    
    public function Listing()
    {
        $this->View->Render('pricing/index');       
    }


}

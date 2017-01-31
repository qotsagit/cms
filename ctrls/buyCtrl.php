<?php

/**
 * buyCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/buyModel.php';
include 'views/buyView.php';

class buyCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct(false);

        $this->View = new buyView();
 
        $this->View->ViewTitle = $this->Msg('_BUY_', 'Buy');
        $this->View->CtrlName = CTRL_BUY;
        
        $this->Model = new buyModel(); 
        $this->Validator = new Validator();

        //$this->InitFormFields();
        //$this->InitRequired();
        //$this->InitValidatorFields();
    }

    public function ReadForm()
    {
        
    }

    
    public function Index()
    {
        switch($this->Method)
        {
            case METHOD_TRUE:   $this->True();      break;
            case METHOD_OK:     $this->Ok();        break;  
            case METHOD_ERROR:  $this->Error();     break;
            default:            $this->Listing();   break;
        }
    } 
    
    private function True()
    {
        
        $this->Model->remote_addr = $_SERVER['REMOTE_ADDR'];
        $this->Model->tr_id = filter_input(INPUT_POST,'tr_id');
        $this->Model->tr_date = filter_input(INPUT_POST, 'tr_date');
        $this->Model->tr_crc = filter_input(INPUT_POST,'tr_crc');
        $this->Model->tr_amount = filter_input(INPUT_POST,'tr_amount');
        $this->Model->tr_paid = filter_input(INPUT_POST, 'tr_paid');
        $this->Model->tr_desc = filter_input(INPUT_POST, 'tr_desc');
        $this->Model->tr_status = filter_input(INPUT_POST, 'tr_status');
        $this->Model->tr_error = filter_input(INPUT_POST, 'tr_error');
        $this->Model->tr_email = filter_input(INPUT_POST, 'tr_email');
        $this->Model->md5sum = filter_input(INPUT_POST, 'md5sum');
        $this->Model->test_mode = filter_input(INPUT_POST, 'test_mode');
        $this->Model->wallet = filter_input(INPUT_POST, 'wallet');
        
        $this->Model->Insert();
        print 'TRUE';
        exit;
    }
    
    private function Ok()
    {
        $this->View->Render('buy/index');
    }
    
    private function Error()
    {
        $this->View->Render('buy/error');
    }
    
    public function Listing()
    {
        $this->View->Render('buy/index');
    }

}

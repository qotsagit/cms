<?php

/**
 * sessionCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class sessionCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct( false);
        $this->userModel = new userModel();
    }
    
    private function Index()
    {
        print $this->userModel->Lists();
      
    }
    
   
}

<?php


class customerCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_CUSTOMERS_', 'Customers');
    }

    public function Index()
    {
        print $this->View->Render('underConstruction');
        
    }
    
    
}

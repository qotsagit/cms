<?php


class orderCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_ORDERS_', 'Orders');
    }

    public function Index()
    {
        print $this->View->Render('underConstruction');
    }

}

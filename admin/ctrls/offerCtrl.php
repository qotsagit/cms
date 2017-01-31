<?php


class offerCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_OFFERS_', 'Offers');
    }

    public function Index()
    {
        print $this->View->Render('underConstruction');
    }

}

<?php


class newsletterCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_NEWSLETTER_', 'Newsletter');
    }

    public function Index()
    {
        print $this->View->Render('underConstruction');
    }

}

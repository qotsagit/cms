<?php

/**
 * userpageCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 
include 'views/userpageView.php';

class userpageCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        $this->View = new pageView();
    }

    public function Method()
    {
        $this->Index();
    }

    private function Read()
    {

    }

    public function Index()
    {
        $this->View->Render('page/index');
    }

}

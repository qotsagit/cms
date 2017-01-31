<?php

include 'models/homeModel.php';


class homeCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        //$this->View = new homeView();
        $this->Model = new homeModel();
    }


    public function Index()
    {
        //$this->View->SetTemplate('home/index');
        //$this->View->Render();
    }

}

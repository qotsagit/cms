<?php

include 'models/homeModel.php';
include 'models/userModel.php';
include 'models/categoryModel.php';
include 'models/langModel.php';
include 'models/roleModel.php';
include 'models/msgModel.php';
include 'models/blockModel.php';
include 'models/menuModel.php';
include 'models/pageModel.php';
include 'models/templateModel.php';
include 'models/calendarModel.php';

include 'views/homeView.php';

class homeCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        $this->View = new homeView();
        $this->Model = new homeModel();
        $this->userModel = new userModel();
        $this->categoryModel = new categoryModel();
        $this->langModel = new langModel();
        $this->roleModel = new roleModel();
        $this->msgModel = new msgModel();
        $this->blockModel = new blockModel();
        $this->menuModel = new menuModel();
        $this->pageModel = new pageModel();
        $this->templateModel = new templateModel();
        $this->calendarModel = new calendarModel();
    }


    public function Index()
    {
        $this->View->UserCount = $this->userModel->CountAll();
        $this->View->CategoryCount = $this->categoryModel->CountAll();
        $this->View->LangCount = $this->langModel->CountAll();
        $this->View->RoleCount = $this->roleModel->CountAll();
        $this->View->MsgCount = $this->msgModel->CountAll();
        $this->View->BlockCount = $this->blockModel->CountAll();
        $this->View->MenuCount = $this->menuModel->CountAll();
        $this->View->PageCount = $this->pageModel->CountAll();
        $this->View->TemplateCount = $this->templateModel->CountAll();
        $this->View->CalendarCount = $this->calendarModel->CountAll();
        
        $this->View->Render('home/index');
    }

}

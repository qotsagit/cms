<?php
/**
 * backupCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2017-03-18 maxkod.pl
 * @version    1.0
 */

include 'views/updateView.php';

class updateCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct();

        $this->View = new updateView();
        $this->View->ViewTitle = $this->Msg('_UPDATE_', 'Update');
        $this->View->CtrlName = CTRL_UPDATE;

    }
    
    private function Start()
    {
        $f = fopen("http://maxkod.pl/update.tar.gz","r");
        
        if($f == NULL)
            print 'no file';        
        else
            print 'file';
        print 'aaaaaaaaaaaa';
        //system();
    }
    
    public function Index()
    {
        switch($this->Method)
        {
            case 'start': $this->Start(); break;
            default : $this->View->Render('update/index.html'); break;
        }
        
        
        //print 'aaaa';
        //print $this->Method;
    }

}

    


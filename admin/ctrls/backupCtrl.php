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

include 'views/backupView.php';

class backupCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct();
        $this->View = new backupView();
    }
    
    public function Index()
    {
        $this->View->Render('backup/index.html');
        print $this->Method;
    }

}

    


<?php
/**
 * productCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'ctrls/pageCtrl.php';


class newsCtrl extends pageCtrl 
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_NEWS_', 'News');
        $this->View->CtrlName = CTRL_NEWS;
        $this->Model->content_type = CONTENT_NEWS;
        $this->View->ContentType->Value = CONTENT_PAGE;    
    }
}

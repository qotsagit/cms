<?php
/**
 * galleryCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
include 'ctrls/pageCtrl.php';


class galleryCtrl extends pageCtrl 
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_GALLERY_', 'Gallery');
        $this->View->CtrlName = CTRL_GALLERY;
        $this->Model->content_type = CONTENT_GALLERY;
        
    }
}

 
?>

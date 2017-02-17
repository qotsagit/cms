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


class productCtrl extends pageCtrl 
{
    public function __construct()
    {
        parent::__construct();
        $this->View->ViewTitle = $this->Msg('_PRODUCT_', 'Product');
        $this->View->CtrlName = CTRL_PRODUCT;
        $this->Model->content_type = CONTENT_PRODUCT;
        $this->View->ContentType->Value = CONTENT_PRODUCT;    
    }
}

 
?>
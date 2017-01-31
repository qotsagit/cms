<?php

/**
 * newsletterCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/newsletterModel.php';
include 'views/newsletterView.php';

class newsletterCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct(false);
        $this->View = new newsletterView();        
        $this->Model = new newsletterModel(); 

    }
    
    
    public function Index()
    {
        switch($this->Method)
        {
            case METHOD_SAVE:   $this->Save();      break;
            default:            $this->Listing();   break;
        }
    } 
    
    public function Save()
    {
        $email = $_POST['email'];
        $msg = array();
        
        if($this->IsValidEmail($email))
        {
            $this->Model->email = $email;
            $this->Model->Insert();
        
            $msg = array
            (
                'code'  => 1,
                'text'  => '<div class="alert alert-info">'.$this->Msg('_NEWSLETTER_SAVE_','Newsletter Save').'</div>'
            );
        
        }else{
            
            $msg = array
            (
                'code'  => 0,
                'text'  => '<div class="alert alert-danger">'.$this->Msg('_EMAIL_NOT_VALID_','Email Not Valid').'</div>'
            );
                
        }
        
        print json_encode($msg);
    }
    
    public function Listing()
    {
        print '<div class="alert alert-danger">ERROR</div>';
    }

}

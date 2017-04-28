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
include 'models/userModel.php';
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
    

    public function Send()
    {

		$email = new Email(SMTP_NEWSLETTER_HOST,SMTP_NEWSLETTER_PORT,SMTP_NEWSLETTER_USER,SMTP_NEWSLETTER_PASSWORD);
        //$email->Send(SMTP_TO, $this->Msg('_PRICING_','Pricing'),$msg);   
	
		$user = new userModel();
		$users = $user->All();
	
		$newsletters = $this->Model->All();
	
		foreach($newsletters as $newsletter)
		{
			print $newsletter->title;
			foreach($users as $user)
			{
				if($user->newsletter)
				{
					//print $user->email;
					if($email->Send(SMTP_NEWSLETTER_FROM, $user->email, $newsletter->title, $newsletter->text) == false)
						print $this->LastError;
				}
			}
			
			$newsletter->Activate(false);
		}
	
    }
    
    public function Test()
    {
		$email = new Email();
        $email->Send(SMTP_TO, 'newsletter', 'testowy email z newslettera');
    }


    public function Listing()
    {
        print '<div class="alert alert-danger">ERROR</div>';
    }

}

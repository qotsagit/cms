<?php

/**
 * courseCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/courseModel.php';
include 'views/courseView.php';

class courseCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct(false);
        $this->View = new courseView();        
        $this->Model = new courseModel(); 

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

	public function Options()
	{
		
		foreach($this->Model->Available() as $item)
		{
			print "<option>".$item->name." ".$item->start_date."</option>";
		}
		
	}
	
    public function Listing()
    {
		$this->Model->SetOrder("start_date",SORT_ASC);
		$this->View->SetValues();
		
		$this->View->SetItems($this->Model);
        print json_encode($this->View->Items);
    }

}

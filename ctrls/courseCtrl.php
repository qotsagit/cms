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
include 'models/userModel.php';
include 'models/courseuserModel.php';
include 'views/courseView.php';

//pola formularza
define('COURSE_ID','id_course');
define('COURSE_NAME','name');
define('COURSE_EMAIL','email');
define('COURSE_FIRST_NAME','first_name');
define('COURSE_LAST_NAME','last_name');
define('COURSE_PHONE','phone');

class courseCtrl extends Ctrl
{
    public function __construct()
    {
        parent::__construct(false);
        $this->View = new courseView();        
        $this->Model = new courseModel(); 
		
		$this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }
	
	private function InitFormFields()
    {
		$this->View->Id = new Input();
		$this->View->IdCourse = new Input();
        $this->View->Email = new Input();
		$this->View->Email->SetFieldLabel($this->Msg("_EMAIL_","Email"));
		$this->View->Email->SetFieldName(COURSE_EMAIL);
		
        $this->View->FirstName = new Input();
		$this->View->FirstName->SetFieldLabel($this->Msg("_FIRST_NAME_","First Name"));
		$this->View->FirstName->SetFieldName(COURSE_FIRST_NAME);
		
		$this->View->Phone = new Input();
		$this->View->Phone->SetFieldLabel($this->Msg("_PHONE_","Phone"));
        $this->View->Phone->SetFieldName(COURSE_PHONE);
		
		$this->View->LastName = new Input();
		$this->View->LastName->SetFieldLabel($this->Msg("_LAST_NAME_","Last Name"));
		$this->View->LastName->SetFieldName(COURSE_LAST_NAME);
	}

    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
        $this->View->FirstName->SetRequired(true);
        $this->View->LastName->SetRequired(true);
		$this->View->Phone->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
        $this->Validator->Add($this->View->FirstName);
        $this->Validator->Add($this->View->LastName);
		$this->Validator->Add($this->View->Phone);
    }
    
    public function ReadForm()
    {
		$this->View->IdCourse->Value = filter_input(INPUT_POST, COURSE_ID);
        $this->View->Email->Value = filter_input(INPUT_POST, COURSE_EMAIL);
        $this->View->Phone->Value = filter_input(INPUT_POST, COURSE_PHONE);
        $this->View->FirstName->Value = filter_input(INPUT_POST, COURSE_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, COURSE_LAST_NAME);   
    }
	

	public function Insert()
	{
		$userModel = new userModel();
		$userModel->email = $this->View->Email->Value;
		$user = $userModel->EmailExists();
		
		if($user == NULL)
		{
			$userModel->email = $this->View->Email->Value;
			$userModel->first_name = $this->View->FirstName->Value;
			$userModel->last_name = $this->View->LastName->Value;
			$userModel->phone = $this->View->Phone->Value;
			$userModel->Insert();
			$user = $userModel->EmailExists();
		}
		
		
		if($user)
		{
			//print_r($user);
			$courseuserModel = new courseuserModel();
			$courseuserModel->id_user = $user->id_user;
			$courseuserModel->id_course = $this->View->IdCourse->Value;
			$courseuserModel->Insert();	
		}
		
		//print "insert course";
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
			print "<option value='".$item->GetId()."'>".$item->name." ".$item->start_date."</option>";
		}
		
	}
	
    public function Listing()
    {
		//$this->Model->SetOrder("start_date",SORT_ASC);
		//$this->View->SetValues();
		
		//$this->View->SetItems($this->Model->Lists());
        //print json_encode($this->View->Items);
    }

}

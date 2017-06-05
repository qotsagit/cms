<?php

/**
 * contactCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/contactModel.php';
include 'models/placeModel.php';
include 'views/contactView.php';

class contactCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct(false);

        $this->View = new contactView();
 
        $this->View->ViewTitle = $this->Msg('_CONTACT_', 'Contact');
        $this->View->CtrlName = CTRL_CONTACT;
        
        $this->Model = new contactModel(); 
        $this->Validator = new Validator();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
	$this->View->Id = new Input();
        $this->View->Email = new Input();
        $this->View->FirstName = new Input();
        $this->View->LastName = new Input();
        $this->View->Phone = new Input();
        $this->View->Subject = new Input();
        $this->View->Message = new Input();
        $this->View->Newsletter = new Input();
        $this->View->Newsletter->Value = true;
    }
    
    private function ClearFormFields()
    {
        $this->View->Email->Value = NULL;
        $this->View->FirstName->Value = NULL;
        $this->View->LastName->Value = NULL;
        $this->View->Phone->Value = NULL;
        $this->View->Subject->Value = NULL;
        $this->View->Message->Value = NULL;
    }

    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
    }
    
    public function ReadForm()
    {
        $this->View->Email->Value = filter_input(INPUT_POST, CONTACT_EMAIL);
        $this->View->Phone->Value = filter_input(INPUT_POST, CONTACT_PHONE);
        $this->View->FirstName->Value = filter_input(INPUT_POST, CONTACT_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, CONTACT_LAST_NAME);
        $this->View->Subject->Value = filter_input(INPUT_POST, CONTACT_SUBJECT);
        $this->View->Message->Value = filter_input(INPUT_POST, CONTACT_MESSAGE);
        $this->View->Newsletter->Value = filter_input(INPUT_POST, CONTACT_NEWSLETTER);
    }

    public function Insert()
    {
        $this->InsertContact();
        //$this->InsertCustomer(); zrezygnowałem z dodawania użytkownika do bazy 

        $email = new Email(SMTP_CONTACT_HOST,SMTP_CONTACT_PORT,SMTP_CONTACT_USER,SMTP_CONTACT_PASSWORD);
        
        $msg  = "<a href=mailto:".$this->View->Email->Value.">".$this->View->Email->Value."</a><br>";
        $msg .= $this->Msg('_FIRST_NAME_','First Name').': '. $this->View->FirstName->Value."<br>";
        $msg .= $this->Msg('_LAST_NAME_','Last Name').': '.$this->View->LastName->Value."<br>";
        $msg .= $this->Msg('_PHONE_','Phone').': '.$this->View->Phone->Value."<br>";
        $msg .= $this->Msg('_SUBJECT_','Subject').': '.$this->View->Subject->Value."<br>";
        $msg .= $this->Msg('_MESSAGE_','Message').'<br>'.$this->View->Message->Value."<br>";
        
        $email->Send(SMTP_CONTACT_FROM,SMTP_CONTACT_TO, $this->View->Subject->Value,$msg);   
    }
    
    public function InsertContact()
    {
        $this->Model->email = $this->View->Email->Value;
        $this->Model->first_name = $this->View->FirstName->Value;
        $this->Model->last_name = $this->View->LastName->Value;
        $this->Model->phone = $this->View->Phone->Value;
        $this->Model->subject = $this->View->Subject->Value;
        $this->Model->message = $this->View->Message->Value;
        
        if($this->View->Newsletter->Value == 'on')
            $this->Model->newsletter = true;
        else
            $this->Model->newsletter = false;
        
        $this->Model->Insert();
    }
        
    private function InsertCustomer()
    {
        $customer = new customerModel();
        
        $customer->email = $this->View->Email->Value;
        $customer->first_name = $this->View->FirstName->Value;
        $customer->last_name = $this->View->LastName->Value;
        $customer->phone = $this->View->Phone->Value;
        
        $item = $customer->EmailExists(); 
                
        if($item == NULL)
        {
            $customer->Insert();
        }
    }
    
    // nadpisaliśmy sobie dla formularza z ajax
    // bo trochę inaczej obsłużymy formularz
    // jeżeli będziemy chcieli powrócić do strej wersji z
    // przeładowaniem to tą funkcję trzeba wykomentować
    /*
    public function Save()
    {
        $this->ReadForm();
        if ($this->Validate())
        {
           
            //$this->Insert();
           
        }
        else
        {
            $this->View->Validation = VALIDATION_FALSE;
            //$this->FormAdd();
        }
        
    }
    */
    
    public function FormAdd()
    {
        $this->View->Title = $this->Msg('_NEW_','New');
        $this->View->Render('contact/index');
    }
    
    
    //returns a JSON places list from place model
    public function PlacesJson()
    {
     
        $placeModel = new placeModel();
        print $placeModel->Json();
            
        //print '[{"lat":51.2641800,"lon":15.5697000,"title":"<h1>Bolesławiec</h1>","text":"Opis bolesławca"},{"lat":51.2641800,"lon":15.6697000,"title":"<h1>Tomaszów</h1>","text":"Opis tomaszowa"},{"lat":51.5641800,"lon":15.6697000,"title":"<h1>aa</h1>","text":"opis czegoś"}]';
        
        // jak jest debug żeby nie był renderowany
        exit; 
    }
    
    
    public function Listing()
    {
        // tego używamy do wyświetlenia listy miejsc w html
        //. . . . . . . . . . . . . . . .

        $placeModel = new placeModel();
        $this->View->SetItems($placeModel->Lists());
        
        //. . . . . . . . . . . . . . . .
        
        $this->ClearFormFields();
        $this->View->Render('contact/index');
    }

}

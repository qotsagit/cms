<?php



// klasa Input dla kontrolek typu input
class Input extends Base
{

    public $IsValid = true;         // flaga czy pole zawiera poprawne dane
    public $Error = false;          // flaga błędu validacji
    public $ErrorText = array();    // tekst błędu validacji
    public $ErrorStyle;             // styl błędu pola input 'has-error'
    public $Value;                  // wartość pola input
    public $InValidator = false;    // flaga do DEBUG czy pole zostało przekazane do Validatora
    public $RequiredText;           // tekst pole wymagane (*)
    public $Match;                  // wartość pól taka sama
    public $MinLength;              // minimalna długość pola
    public $MaxLength;              // maxymalna długość pola
    public $StartDate;              // porównanie pól z datą
    public $EndDate;                // porównanie pól z datą
    public $UniqueEmail = false;    // unikalny email
    public $Checked = false;        // waliduj chceckbox
    public $FieldLabel;              // label pola
    
    public $Type = FIELD_TYPE_INPUT;

    private $Required = false;    // czy pole wymagane
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function SetType($type)
    {
        $this->Type = $type;
    }

    public function SetFieldName($field_name)
    {
        $this->FieldName = $field_name;
    }
    
    public function SetFieldLabel($field_label)
    {
        $this->FieldLabel = $field_label;
    }
    
    public function SetRequired($value)
    {
        $this->Required = $value;
        if($value)
            $this->RequiredText = '(*)';
    }
    
    public function SetChecked($value)
    {
        $this->Checked = $value;
    }
    
    public function SetMatch($field)
    {
        $this->Match = $field;
    }
    
    public function SetDate($start,$end)
    {
        $this->StartDate = $start;
        $this->EndDate = $end;
    }
    public function SetMinLength($value)
    {
        $this->MinLength = $value;
    }
    
    public function SetMaxLength($value)
    {
        $this->MaxLength = $value;
    }
    
    public function SetUniqueEmail()
    {
        $this->UniqueEmail = true; 
    }
   
    private function CheckRequired()
    {
        if ($this->Required)
        {
            if (empty($this->Value))
            {
                $this->AppendError($this->ErrorText,$this->FieldLabel.' - '.$this->Msg('_FIELD_IS_REQUIRED_','Field Is Required'));
                $this->ErrorStyle = 'has-error';
                $this->IsValid = false;
            }
        }
    }
    
    private function CheckChecked()
    {
        if($this->Checked)
        {
            if (sizeof($this->Value) == 0)
            {
                $this->AppendError($this->ErrorText,$this->Msg('_SELECT_OPTION_','Select option'));
                $this->ErrorStyle = 'has-error';
                $this->IsValid = false;
            }
        }
    }
    
    private function CheckMinLength()
    {
        if(isset($this->MinLength))
        {
            $len = strlen($this->Value);
            if($len < $this->MinLength)
            {
                $this->AppendError($this->ErrorText, $this->Msg('_MIN_LENGTH_','Minimum Length').' ('.$this->MinLength.')('.$len.')');
                $this->ErrorStyle = 'has-error';
                $this->IsValid = false;
            }
        }
    }
    
    private function CheckMaxLength()
    {
        if(isset($this->MaxLength))
        {
            $len = strlen($this->Value);
            if($len > $this->MaxLength)
            {
                $this->AppendError($this->ErrorText, $this->Msg('_MAX_LENGTH_','Max Length').' ('.$this->MaxLength.')('.$len.')');
                $this->ErrorStyle = 'has-error';
                $this->IsValid = false;
            }
        }
    }
    
    private function CheckMatch()
    {
        if(isset($this->Match))
        {
            if(strcmp($this->Value,$this->Match->Value) !== 0 )
            {
                $this->AppendError($this->ErrorText, $this->Msg('_FIELD_NOT_MATCH_','Field Not Match'));
                $this->IsValid = false;
            }
        }
    }

    private function CheckEmail()
    {
        if ($this->Type == FIELD_TYPE_EMAIL)
        {
            if (!$this->IsValidEmail($this->Value))
            {
                $this->AppendError($this->ErrorText, $this->Msg('_EMAIL_NOT_VALID_','Email Not Valid'));
                $this->IsValid = false;
            }
        }
    }
    
    // compare dates start,end
    private function CheckDate()
    {
        if(isset($this->StartDate) && isset($this->EndDate))
        {
            $d1 = strtotime($this->StartDate->Value);
            $d2 = strtotime($this->EndDate->Value);
            $result = $d1 - $d2;
            
            if($result > 0)
            {
                $this->AppendError($this->StartDate->ErrorText,$this->Msg('_NOT_VALID_DATE_','Not valid date'));
                $this->AppendError($this->EndDate->ErrorText, $this->Msg('_NOT_VALID_DATE_','Not valid date'));
                $this->IsValid = false;
            }
        }
    }
    
    private function CheckUniqueEmail()
    {
        if($this->UniqueEmail)
        {
            $params = array(':email'=>$this->Value);
            if($this->DB->Count("SELECT count(*) FROM user WHERE email=:email",$params))
            {
                $this->AppendError($this->ErrorText, $this->Msg('_EMAIL_EXISTS_','Email Exists'));
                $this->IsValid = false;
            }
            
        }
    }

    private function AppendError(&$field,$text)
    {
        array_push($field,$text);
    }
   
    public function Validate()
    {
        $this->CheckRequired();
        $this->CheckChecked();
        $this->CheckMaxLength();
        $this->CheckMinLength();
        $this->CheckMatch();
        $this->CheckDate();
        $this->CheckEmail();
        $this->CheckUniqueEmail();
    }
    
}

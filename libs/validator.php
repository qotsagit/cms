<?php


// klasa Input dla kontrolek typu input
class Validator
{

    private $Fields;

    public function __construct()
    {
        $this->Fields = array();
    }

    public function Add(Input $field)
    {
        $field->InValidator = true;
        array_push($this->Fields,$field);
    }
    
    public function Validate()
    {
        // sprawdź wszystkie pola
        foreach ($this->Fields as $field)
        {
            $field->Validate();
        }
        //i dopiero po sprawdzeniu podaj wynik
        foreach ($this->Fields as $field)
        {
            if($field->IsValid == false)
                return false;
        }
        
        return true;
    }
    
}

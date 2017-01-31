<?php

class myException extends Exception
{
    public $Title;
    public $Text;
    
    public function __construct($title, $text = '')
    {       
        $this->Title = $title;
        $this->Text = $text;
        include TEMPLATE_FOLDER . '/exception/index.html';
        exit;
    }

    private function WriteLog()
    {
        
    }
    
}
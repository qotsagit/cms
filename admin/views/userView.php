<?php

class userView extends View
{
    // pola formularza
    public $_Id;
    public $IdUser;
    public $IdLang;
    public $IdRole;
    public $Email;
    public $Phone;
    public $FirstName;
    public $LastName;
    public $Nick;
    public $Password;
        
    public $Active;         // status użytkownika z tablicy Settings::$UserStatus
    public $OldPassword;    // używane do sprawdzenia czy użytkownik zmienił hasło
   
    //public $Languages;      // lista języków
    public $Roles;          // lista ról
    public $Statuses;       // lista statusów
    
    
    public function __construct()
    {    
        parent::__construct();
        
    }
    
    public function SetColumns()
    {
        
         $this->Columns = array
            (

            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_user',false),
            new ColumnAvatar($this->Msg('_IMAGE_','Image'), 'avatar'),
            new ColumnText($this->Msg('_NICK_','Nick'), 'nick'),
            new ColumnText($this->Msg('_EMAIL_','Email'), 'email'),
            new ColumnText($this->Msg('_FIRST_NAME_','First Name'), 'first_name'),
            new ColumnText($this->Msg('_LAST_NAME_','Last Name'),'last_name'),
            new ColumnActive($this->Msg('_ACTIVE_','Active'), 'active',$this->Statuses)
        );
        
    }

    /*    
    public function RenderTableBody($view)
    {
        print '<tbody>';

        $id = ($view->Page * $view->Limit) - $view->Limit + 1;
        foreach ($view->Items as $item)
        {
            if ($view->Id == $item->GetId())
                print '<tr class="success">';
            else
                print '<tr>';

            print '<td width="140px;">';
            $this->RenderRowMenu($view, $item);
            print '</td>';
            print '<td class="text-right">' . $id . '</td>';

            foreach ($view->Columns as $column)
            {
                if ($column->Visible)
                    $column->Render($item);
            }

            print '</tr>';
            $id++;
        }
        print '</tbody>';
    }
    */

    //nadpisujemy 
    //public function render($view)
    //{
      //  include TEMPLATE_FOLDER . '/' . $view . '.html';
    //}

    
}

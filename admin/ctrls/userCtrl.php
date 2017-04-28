<?php

/**
 * userCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/userModel.php';
include 'models/langModel.php';
include 'models/roleModel.php';
include 'models/activeModel.php';

include 'views/userView.php';

//Opis link
// 1/30/1
// p1 - strona
// p2 - limit
// p3 - columna sortowania   liczba
// p4 - malejąco czy rosnąco liczba 0 lub 1
class userCtrl extends Ctrl
{

    private $md5 = false;
    
    public function __construct()
    {
        parent::__construct();

        $this->View = new userView();

        // potrzebne przy listingu itp..
        $items = new activeModel();
        
        $this->View->ViewTitle = $this->Msg('_USERS_', 'Users');
        $this->View->CtrlName = CTRL_USER;
        
        $this->View->Statuses = $items->All();

        $this->Model = new userModel();
        $this->Validator = new Validator();

        $this->InitFormFields();
        $this->InitRequired();
        $this->InitValidatorFields();
    }

    private function InitFormFields()
    {
        $this->View->Id = new Input();
        $this->View->IdUser = new Input();
        $this->View->IdLang = new Input();
        $this->View->IdRole = new Input();
        $this->View->Email = new Input();
        $this->View->Nick = new Input();
        $this->View->Password = new Input();
        $this->View->OldPassword = new Input();
        $this->View->Phone = new Input();
        $this->View->FirstName = new Input();
        $this->View->LastName = new Input();
        $this->View->Active = new Input();
        $this->View->Active->Value = STATUS_ACTIVE;
        
        //avatar
        $this->View->Avatar = new Input();
        $this->View->Avatar->Value = DEFAULT_AVATAR;
        
        $this->View->OldAvatar = new Input();
    }

    private function InitRequired()
    {
        $this->View->Email->SetRequired(true);
        $this->View->Nick->SetRequired(true);
        $this->View->Nick->SetMinLength(3);
        $this->View->Password->SetRequired(true);
        $this->View->FirstName->SetRequired(true);
        $this->View->LastName->SetRequired(true);
    }

    private function InitValidatorFields()
    {
        $this->Validator->Add($this->View->Email);
        $this->Validator->Add($this->View->Nick);
        $this->Validator->Add($this->View->Password);
        $this->Validator->Add($this->View->FirstName);
        $this->Validator->Add($this->View->LastName);
    }
    
    public function ReadForm()
    {
        $this->View->Id->Value = filter_input(INPUT_POST, ID);
        $this->View->IdUser->Value = filter_input(INPUT_POST, IDUSER);
        $this->View->IdLang->Value = filter_input(INPUT_POST, IDLANG);
        $this->View->IdRole->Value = filter_input(INPUT_POST, IDROLE);
        $this->View->Email->Value = filter_input(INPUT_POST, USER_EMAIL);
        $this->View->Phone->Value = filter_input(INPUT_POST, USER_PHONE);
        $this->View->FirstName->Value = filter_input(INPUT_POST, USER_FIRST_NAME);
        $this->View->LastName->Value = filter_input(INPUT_POST, USER_LAST_NAME);
        $this->View->Nick->Value = filter_input(INPUT_POST, USER_NICK);
        $this->View->OldPassword->Value = filter_input(INPUT_POST, USER_OLD_PASSWORD);
        $this->View->Password->Value = filter_input(INPUT_POST, USER_PASSWORD);
        $this->View->Active->Value = filter_input(INPUT_POST, USER_STATUS);
        //$this->View->Avatar->Value = DEFAULT_AVATAR;

        if ($this->View->IdUser->Value > 0)
            $this->ReadPasswordUpdate();
        else
            $this->ReadPasswordInsert();
        
        $filename = $this->Upload();
        if(empty($filename))
        {
            $old_avatar = filter_input(INPUT_POST, USER_OLD_AVATAR);
            if(!empty($old_avatar))
            {
                $this->View->Avatar->Value = $old_avatar;
            }
            
        }else{
            
            $this->Image = new Image();
            $avatar = AVATAR_DIR.'/'.$filename;
            $this->Image->ResizeAndCrop($avatar,$avatar,AVATAR_WIDTH,AVATAR_HEIGHT);
            $this->View->Avatar->Value = $filename;
            
        }
        
    }

    public function ReadPasswordUpdate()
    {
        if (!empty($this->View->Password->Value))
        {
            if ($this->View->OldPassword->Value == $this->View->Password->Value)
            {
                // nie zmienione
                $this->View->Password->Value = $this->View->OldPassword->Value;
            
            }else{
                $this->md5 = true;
                $this->View->Password->Value = $this->View->Password->Value;
            }
        }
       
    }
    
    public function ReadPasswordInsert()
    {
       $this->View->Password->Value = $this->View->Password->Value;
    }
 
    public function Upload()
    {
        
        if(isset($_FILES[ 'avatar' ][ 'tmp_name' ][0])) // taka konstrukcja powoduje brak warningów
        {
            $image = $_FILES[ 'avatar' ][ 'tmp_name' ][0];
            if($image)
            {
                if (!$this->DirectoryExists(AVATAR_DIR)) 
                {
                    if (!$this->DirectoryCreate(AVATAR_DIR))
                    {
                        return false; 
                    }
                }
                
                $avatar = $this->RandomString(10);
                $target_path = AVATAR_DIR .'/'.$avatar; 

                if ( move_uploaded_file( $image, $target_path ) )
                {
                    return $avatar;
                } 
                else 
                {
                    return false;
                }
            }
        }
    }
    

    public function ReadDatabase()
    {
        $array = $this->Model->Get($this->View->_Id);

        foreach ($array as $item)
        {
            $this->View->Id->Value = $item->id_user;
            $this->View->IdUser->Value = $item->id_user;
            $this->View->IdLang->Value = $item->id_lang;
            $this->View->IdRole->Value = $item->id_role;
            $this->View->Email->Value = $item->email;
            $this->View->FirstName->Value = $item->first_name;
            $this->View->LastName->Value = $item->last_name;
            $this->View->Nick->Value = $item->nick;
            $this->View->Password->Value = $item->password;
            $this->View->OldPassword->Value = $item->password;
            $this->View->Active->Value = $item->active;
            
            if(empty($item->avatar))
            {
                $this->View->Avatar->Value = DEFAULT_AVATAR;
                $this->View->OldAvatar->Value = DEFAULT_AVATAR;
            
            }else{
                
                $this->View->Avatar->Value = $item->avatar;
                $this->View->OldAvatar->Value = $item->avatar;
            }
            
            return true;
        }

        return false;
    }

    public function Insert()
    {
        $this->Model->id_user = $this->View->IdUser->Value;
        $this->Model->id_lang = Session::GetLang(); //$this->View->IdLang->Value;
        $this->Model->id_role = $this->View->IdRole->Value;
        $this->Model->nick = $this->View->Nick->Value;
        $this->Model->email = $this->View->Email->Value;
        $this->Model->first_name = $this->View->FirstName->Value;
        $this->Model->last_name = $this->View->LastName->Value;
        
        $this->Model->active = $this->View->Active->Value;
        $this->Model->avatar = $this->View->Avatar->Value;

        if ($this->View->IdUser->Value > 0)
        {
            if($this->md5)
                $this->Model->password = md5($this->View->Password->Value);
            else
                $this->Model->password = $this->View->Password->Value;
            
            $this->Model->Update();
        }
        else
        {
            $this->Model->password = md5($this->View->Password->Value);
            $this->Model->Insert();
        }
    }
    
    public function DeleteConfirm()
    {
        $this->ReadForm();
        $this->Model->id = $this->View->Id->Value;
        $this->Model->Delete();
        $this->Listing();
    }
   
    public function FormAdd()
    {
        $items = new langModel();
        $this->View->Languages = $items->All();

        $items = new roleModel();
        $this->View->Roles = $items->All();

        $this->View->Title = $this->Msg('_NEW_','New') ;

        $this->View->Render('user/add');
    }

    public function FormEdit()
    {
        $items = new langModel();
        $this->View->Languages = $items->All();

        $items = new roleModel();
        $this->View->Roles = $items->All();

        $this->View->Title = $this->Msg('_EDIT_','Edit') ;
        
        if ($this->ReadDatabase())
        {
    
            $this->View->Render('user/add');
        
        }else{
        
             new myException('DATABASE ERROR');
        
        }
    }
    
    
}

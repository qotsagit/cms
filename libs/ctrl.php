<?php


abstract class Ctrl extends Base
{
    public $View;
    public $Model;

    private $Email;
    private $Password;
    private $RememberMe = false;
    // używają inne kontrolery część wspólna dla wszystkich
    public $Method;                     //jak metoda
    public $Params;
    public $Type = USER_TYPE_USER;      // user type for login to admin or page
	public $Option;						// czy to opcja
   
    
    public function __construct($login = true, $type = USER_TYPE_USER)
    {   
        parent::__construct();
        $this->Validator = new Validator();
        $this->Model = new Model();
        $this->View = new View();
        $this->NeedAuth = $login;
        $this->Type = $type;
    }
    
    public function Init()
    {
        // ustawiamy widokowi defaultowy model
		
		//print 'controller '.$this->Ctrl;
		//print '<br>';
		//print 'method'.$this->Method;
		//default model z CTRL set
		$this->View->Model = $this->Model;
		
        if($this->Read())
		{
			$this->CheckForm(true);   // sprawdzamy login z formularza
        }
		else
		{
			$this->CheckForm(false);   // sprawdzamy login z sesji
			// możemy tą opcję wyłączyć i po poprawnym zalogowaniu ufać tylko sesji
			// a możemy zostawić i sprawdzać to co jest w sesji z bazą danych
		}

        $this->ReadSession();               //czytanie z sesji
        $this->ReadOptions();
        $this->CheckRequest();
		$this->SetVisit();
      
    }
    
	private function SetVisit()
    {
        $this->Model->InsertVisit();
    }
	
	// można nadpisać bo np kontroller page na stronie głównej nie ma pamiętać
    // niektórych rzeczy
    public function ReadSession()
    {
        $this->View->_Id = Session::GetId();
        $this->View->_IdParent = Session::GetIdParent();
        $this->View->Page = Session::GetPage();
		$this->View->PageTo = Session::GetPageTo();
        $this->View->Limit = Session::GetLimit();
        $this->View->OrderColumnId = Session::GetOrderColumnId();
        $this->View->Asc = Session::GetAsc();
    }
    
    // parsowanie parametrów na opcje
    // format name-value
    // opcje nie powodują żadnych akcji zmiany metody
    private function ReadOptions()
    {

        @$options = explode('/',$_GET[URL]);

        foreach($options as $option)
        {
			
            $values = explode('-',$option,2);
            if(sizeof($values) == 2)
            {
                @list($option,$value) =  $values;
				if(method_exists($this, $option))
				{
					$this->Option = $option.'-'.$value;
				    $this->$option($value);
				}   
            }
        }
		
		 //jezyk systemu
        if (!empty($_REQUEST[IDLANG]))
		{
			$this->SetLang($_REQUEST[IDLANG]);
			header("Location: ".BASE_HREF);
		}
		
    }
    
    // metody wywoływane z loadera na podstawie url zmiennej method
    public function Load()
    {
	
		$action = $this->Method;
	
		if(method_exists($this, $action))
        {
            $this->$action();
        
		}else{
           
			//new myException('METHOD NOT EXISTS',$action);
			$this->Index();
		}     

    }
	
	
    // from POST
    private function Search()
    {
        $value = $_POST[SEARCH];
        $this->View->Search = $value;
        Session::SetSearch($value);
		$this->Index();
    }
    
    private function Add()
	{
        $this->FormAdd();
    }

    private function AddNews()
    {
        $this->FormAddNews();
    }
        
    private function Delete()
    {
        @list($id) = $options = explode('/',$this->Params);
        $this->SetId($id);
        $this->FormDelete();
    }
    
    private function Copy()
    {
        @list($id) = $options = explode('/',$this->Params);
        $this->SetId($id);
        $this->FormCopy();
    }

    private function Parent()
    {   
        @list($id) = $options = explode('/',$this->Params);
        $this->SetIdParent($id);
        $this->Listing();
    }

    private function Edit()
    {   
        @list($id) = $options = explode('/',$this->Params);
        $this->SetId($id);
        $this->FormEdit();
    }
    
    private function SetLimit($value)
    {
        $this->View->SetLimit($value);
        Session::SetLimit($value);   
    }

    private function SetId($value)
    {
        if(is_numeric($value) == false)
        {   
            $value = DEFAULT_ID;
        }

        $this->View->_Id = $value;
        Session::SetId($value);  
    }
    
    public function SetIdParent($value)
    {
        if(is_numeric($value) == false)
        {   
            $value = DEFAULT_ID;
        }

        $this->View->_IdParent = $value;
        Session::SetIdParent($value);

    }
    
	private function SetPageTo($value)
	{
		$this->View->Page = $value;
		$this->View->SetPageTo();
		Session::SetPageTo($value);
	}
	
    private function SetPage($value)
    {
        if(is_numeric($value) == false)
        {   
            $value = DEFAULT_PAGE;
        }   

        $this->View->Page = $value;
		$this->View->SetPage();
        Session::SetPage($value);
		Session::SetPageTo($value);
		
		//set page to
		
		//$this->SetPageTo($value);
		
		
    }
	
    private function SetAsc($value)
    {
        $this->View->Asc = $value;
        Session::SetAsc($value);
    }

    private function SetLang($value)
    {
        //$this->View->Asc = $value;
		$lang = $this->GetLang($value);
        
        if($lang)
        {
            Session::SetLang($lang->id_lang);
            Session::SetCurrentPage(NULL);
            //if($this->)
			//header("Location: /");
        }
    }
    
    private function SetOrder($value)
    {
        $this->View->OrderColumnId = $value;   
        Session::SetOrderColumnId($value);
    }

    //weryfikacja danych
    private function CheckRequest()
    {
		// wyłączyliśmy bo limit może być inny niż w tablicach
		return;
        if (array_search($this->View->Limit, Settings::$Limits) == false)
        {
            $this->View->Limit = DEFAULT_LIMIT;
        }
    }

    private function Read()
    {
        // dane z formularza
        $this->Email = filter_input(INPUT_POST, LOGIN_EMAIL);
        $this->Password = filter_input(INPUT_POST, LOGIN_PASSWORD);
        $this->RememberMe = filter_input(INPUT_POST, LOGIN_REMEMBER_ME);
        $this->Login = filter_input(INPUT_POST, METHOD);
        
        // inne dane
        //$data = json_decode(file_get_contents("php://input"), true);
        //$this->Email = $data['email'];
        //$this->Password = $data['password'];
        //printf("DATA: %s", var_export($data, true));

        if ($this->Login == METHOD_LOGIN)
        //if (isset($this->Email) && isset($this->Password))
        {
            $this->Email = md5($this->Email);
            $this->Password = md5($this->Password);
            return true;
        }

        //dane z sesji
        if (isset($_SESSION[LOGIN_EMAIL]) && isset($_SESSION[LOGIN_PASSWORD]))
        {
            $this->Email = $_SESSION[LOGIN_EMAIL];
            $this->Password = $_SESSION[LOGIN_PASSWORD];
            return false;
        }

        //dane z cookie
        if (isset($_COOKIE[LOGIN_EMAIL]) && isset($_COOKIE[LOGIN_PASSWORD]))
        {
            $this->Email = $_COOKIE[LOGIN_EMAIL];
            $this->Password = $_COOKIE[LOGIN_PASSWORD];
            return false;
        }

        return false;
    }

    private function CheckForm($form = true)
    {
        $user = $this->Model->CheckLogin($this->Email, $this->Password, $this->Type);

        if ($user)
        {
            Session::SetValidUser(true);
            Session::SetUser($user);
            //Session::SetLang($user->id_lang);
            $this->User = $user;           
            $this->SetSession();
            $this->SetCookie();
            return true;
        }
        else
        {
            Session::SetValidUser(false);
            $this->View->LoginError = $form;
            return false;
        }
    
    }

    private function Redirect()
    {
        //header('Location:/'.$this->Ctrl);
    }

    private function SetSession()
    {
        //$_SESSION[LOGIN_OWNER] = 
        //Session::SetLang($this->User->id_lang);

        $_SESSION[LOGIN_EMAIL] = $this->Email;
        $_SESSION[LOGIN_PASSWORD] = $this->Password;
    }

    private function SetCookie()
    {
        if ($this->RememberMe)
        {
            setcookie(LOGIN_EMAIL, $_SESSION[LOGIN_EMAIL], time() + (86400 * 7)); // 86400 = 1 day
            setcookie(LOGIN_PASSWORD, $_SESSION[LOGIN_PASSWORD], time() + (86400 * 7));
        }
    }
     
    public function Validate()
    {
        return $this->Validator->Validate();
    }
    
    private function View()
    {
        $this->ReadForm();
        if ($this->Validate())
        {
            $this->View->Validation = VALIDATION_TRUE;
            $this->FormPreview();
        }
        else
        {
            $this->View->Validation = VALIDATION_FALSE;
            $this->FormAdd();
        }
        
    }
    
    // page preview
    private function Preview()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }

    public function Save()
    {
        $this->ReadForm();
        if ($this->Validate())
        {
            $this->View->Saved = true;
            $this->View->Validation = VALIDATION_TRUE;
			
			if($this->View->Id->Value == 0)
			{
				$this->Insert();
			}else{
				$this->Update();
			}
			
            $this->Listing();
        }
        else
        {
            $this->View->Validation = VALIDATION_FALSE;
            $this->FormAdd();
        }
    }
    
	// zapis formularzy ajax np formularz szkoły programowania
	// zapisu na kurs
	public function SaveJSON()
    {
        $this->ReadForm();
        if ($this->Validate())
        {
            $this->View->Saved = true;
            $this->View->Validation = VALIDATION_TRUE;
			$this->Validator->JSON();
			
			if($this->View->Id->Value == 0)
			{
				$this->Insert();
			}else{
				$this->Update();
			}
			
        }
        else
        {
            $this->View->Validation = VALIDATION_FALSE;
            $this->Validator->JSON();
        }
    }
	
	
	
    public function DeleteConfirm()
    {
        $this->ReadForm();
        $this->Model->id = $this->View->Id->Value;
        $this->Model->Delete();
        $this->Listing();
    }
    
    public function CopyConfirm()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
    
    public function Insert()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
	
	public function Update()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }

    public function FormAdd()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
    
    public function FormAddNews()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
    
    public function FormEdit()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }

    public function ReadDatabase()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
    
    public function FormDelete()
    {
        
        if ($this->ReadDatabase())
        {
            $this->View->Render('delete');
        
        }else{
        
            new myException('DATABASE ERROR DELETE');
        }
    }
    
    public function FormCopy()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }

    public function FormPreview()
    {
        new myException('NOT IMPLEMENTED',__FUNCTION__);
    }
    

    public function Listing()
    {
		$this->View->SetColumns();
		$this->View->SetValues();
        $this->View->SetItems($this->Model->Lists());
        $this->View->Render('listView');
    }
    
    public function Content()
    {
		new myException('NOT IMPLEMENTED',__FUNCTION__);
    }

    public function Index()
    {
        $this->Listing();
    }

    // for ajax request
    public function Options()
    {
        
    }
    
    public function JSON()
    {
        
    }
    
}

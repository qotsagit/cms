<?php

class Model extends Base
{

    public $DB;
    public $Limit;
    public $LimitFrom = 0;
    public $Asc = SORT_ASC;                // rosnąco, malejąco
    public $OrderFieldName;                 // ustaw na defaultowe pole   
    // tablice z opisami dla jezyka
    public $Strings;
    public $DefaultStrings;

    public $breadcrumb = array();
    public $items;

    public function __construct()
    {
        parent::__construct();
        //$this->Limit = Session::GetLimit();
    }

    public function GetTitle()
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
    
    //public function GetName()
    //{
      //  new myException('NOT IMPLEMENTED',__FUNCTION__);
    //}

    public function GetImage()
    {
        return DEFAULT_IMAGE;
    }

    public function GetActive()
    {
        return STATUS_ACTIVE;
    }

    // parent item from database
    public function GetCurrentItem()
    {
    
    }
    
    public function CountAll()
    {
        return 0;
    }
    
    public function SetOrder($field,$asc)
	{
		$this->OrderFieldName = $field;
		$this->Asc = $asc;
	}
    
    public function FindPage($url)
    {
        $params = array(':url_address' => $url,':active' => STATUS_ACTIVE);
        return $this->DB->Row('SELECT * FROM page WHERE url_address=:url_address AND active=:active',$params);
    }

    public function GetContentPortfolio()
    {
        $params = array(':content_type' => CONTENT_PORTFOLIO,':id_lang' => Session::GetLang(), ':active' => STATUS_ACTIVE, ':status_extra_image'=> STATUS_EXTRA_IMAGE, ':status_extra_image_logo'=> STATUS_EXTRA_IMAGE_LOGO);
        
        $items = $this->DB->Query('SELECT * FROM page WHERE content_type=:content_type AND active=:active AND (status_extra=:status_extra_image OR status_extra=:status_extra_image_logo ) AND id_lang=:id_lang ', $params, PDO::FETCH_CLASS);
        
        foreach($items as $item)
        {
            $params = array(':id_page' => $item->id_page);
            $sql = "SELECT * FROM image,image_to_page WHERE image_to_page.id_page=:id_page AND image.id_image=image_to_page.id_image ORDER BY image.position LIMIT 1";
            $item->images = $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
        }

        return $items;
    }
    
    public function GetContentNews()
    {
        $params = array(':content_type' => CONTENT_NEWS,':id_lang' => Session::GetLang(), ':active' => STATUS_ACTIVE);
        
        $items = $this->DB->Query('SELECT * FROM page WHERE content_type=:content_type AND active=:active AND id_lang=:id_lang ', $params, PDO::FETCH_CLASS);
        
        foreach($items as $item)
        {
            $params = array(':id_page' => $item->id_page);
            $sql = "SELECT * FROM image,image_to_page WHERE image_to_page.id_page=:id_page AND image.id_image=image_to_page.id_image ORDER BY image.position LIMIT 1";
            $item->images = $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
        }

        return $items;
    }
        
    
    public function GetContentPortfolioLogo()
    {
        $params = array(':content_type' => CONTENT_PORTFOLIO,':id_lang' => Session::GetLang(), ':active' => STATUS_ACTIVE, ':status_extra_logo'=> STATUS_EXTRA_LOGO,  ':status_extra_image_logo'=> STATUS_EXTRA_IMAGE_LOGO);
        
        $items = $this->DB->Query('SELECT title, img FROM page WHERE content_type=:content_type AND active=:active AND (status_extra=:status_extra_logo OR status_extra=:status_extra_image_logo) AND id_lang=:id_lang ', $params, PDO::FETCH_CLASS);

        return $items;
    }
    

    public function GetBlocks($region)
    {
        $regions = new regionModel();
        $region = $regions->Get($region,'name');
        
        if($region)
        {
            $params = array(':id_region' => $region->GetId(),':id_lang' => Session::GetLang(),':active' => STATUS_ACTIVE);
            return $this->DB->Query('SELECT * FROM block WHERE id_region=:id_region AND id_lang=:id_lang AND active=:active', $params, PDO::FETCH_CLASS);
        }
        
        return NULL;
    }
    
    
    public function GetMenus($region)
    {
        $regions = new regionModel();
        $region = $regions->Get($region,'name');
        
        if($region)
        {
            $params = array(':id_region' => $region->GetId(),':id_lang' => Session::GetLang(), ':active' => STATUS_ACTIVE);
            return $this->DB->Query('SELECT * FROM menu WHERE id_region=:id_region AND id_lang=:id_lang AND active=:active', $params, PDO::FETCH_CLASS);
        }
    
        return NULL;
    }
    
    public function GetMenuItems($id_menu,&$items)
    {        
    
        // nie wyświetlamy menuitem aktualnie wybranego do edycji
        $params = array(':id_parent' => $id_menu, ':id_lang' => Session::GetLang(),':active' => STATUS_ACTIVE);    
        $items = $this->DB->Query('SELECT menu.url as murl,name,id_menu,url_address FROM menu LEFT JOIN page ON menu.id_page=page.id_page WHERE menu.id_parent=:id_parent AND menu.id_lang=:id_lang AND menu.active=:active ORDER BY menu.position', $params, PDO::FETCH_CLASS );
       
        foreach($items as $item)
        {
            $this->GetMenuItems($item->id_menu,$item->items);
        }
        
    }
    
    
    public function All()
    {
        return array();    
    }
     
    public function LastInsertId()
    {
        return $this->DB->lastInsertId();
    }

    public function Count()
    {
        return 0;
    }
    
    public function RowCount()
    {
        return $this->DB->RowCount();
    }    

    public function CheckConfirm($email, $password)
    {   
        $params = array(':email' => $email, ':password' => $password,':active' => STATUS_ACTIVE);
        if ($this->DB->Count('SELECT * FROM user WHERE md5(email)=:email AND password=:password AND active=:active', $params, PDO::FETCH_CLASS) == 1)
            return true;
        else
            return false;
    }
   
    public function CheckLogin($email, $password, $type)
    {
        $params = array(':email' => $email, ':nick' => $email, ':password' => $password,':type' => $type, ':active' => STATUS_ACTIVE);
        $array = $this->DB->Query('SELECT * FROM user WHERE (md5(email)=:email OR md5(nick)=:nick) AND password=:password AND type=:type AND active=:active', $params, PDO::FETCH_CLASS);
        if (count($array) == 1)
        {
            return $array[0];
        }
        else
        {
            return false;
        }
    }
    
    public function InsertVisit()
    {
        $params = array(':remote_addr' => $_SERVER['REMOTE_ADDR']);
        $this->DB->Query('INSERT INTO visit SET remote_addr=:remote_addr,date=now()',$params);
    }
    
    public function UniqueVisits()
    {
      
      //$sql = 'SELECT * FROM visit GROUP BY ip';
      //$result = mysql_query($sql);
      //return  mysql_num_rows($result);
            
    }

}


/**
 * regionModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class regionModel extends Model
{
    private $Items;
    
    public $id;
    public $id_region;
    public $name;
    
    
    public function __construct($id = 0, $name ='' )
    {
        parent::__construct();
        $this->id_region = $id;
        $this->name = $name;        
    }
    
    public function GetId()
    {
        return $this->id_region;
    }

    public function GetName()
    {
        return $this->name;
    }
    
    public function Get($name)
    {
        $this->Items = $this->All();
        return $this->Find($name,'name');
    }
    
    private function Find($id,$field)
    {
        foreach ($this->Items as $item)
        {
            if($id == $item->$field)
            {
                return $item;
            }
        }
        
        return NULL;
    }
    
    public function All()
    {
        $this->name = 'top_left';

        return array
        (
            $this,
            new regionModel(1,'top_right'),
            new regionModel(2,'logo'),
            new regionModel(3,'menu'),
            new regionModel(4,'slider'),
            new regionModel(5,'content_top'),
            new regionModel(6,'sidebar_left'),
            new regionModel(7,'content'),
            new regionModel(8,'sidebar_right'),
            new regionModel(9,'content_bottom'),
            new regionModel(10,'footer_1'),
            new regionModel(11,'footer_2'),
            new regionModel(12,'footer_3'),
            new regionModel(13,'footer_4'),
            new regionModel(15,'footer'),
            new regionModel(14,'credits'),
            new regionModel(16,'contact'),
	    new regionModel(17,'footer_5')

        );

    }
    
    public function Lists()
    {
        return NULL;
    }

}


<?php

class pageModel extends Model
{
    
    public $id_msg;
    public $id_lang;
    public $user_value;
    public $default_value;
    public $id_parent = 0;
    public $items;
    public $template_file; 
   
    public function __construct()
    {
        parent::__construct();

        $this->template_file = DEFAULT_TEMPLATE;
        
        $this->OrderFieldName = 'position';
        
    }
 
    public function GetId()
    {
        return $this->id_page;
    }
    
    public function GetName()
    {
        return $this->title;
    }
    
    public function GetTitle()
    {
        return $this->title;
    }

    public function GetPrice()
    {
        return $this->price;
    }

    public function GetText()
    {
        return stripslashes($this->text) ;
    }

    //public function GetImage()
    //{
      //  return $this->img;
    //}

    public function GetLogo()
    {
        return Settings::$ImagesFolder.$this->img;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM msg WHERE id_msg=:id';
        return $this->DB->Query($sql, $params,PDO::FETCH_CLASS);
    }
	
	public function CountAll()
    {
        return $this->Count();
    }
    
	public function Count()
    {
        $params = array(':id_lang' => Session::GetLang(),':id_parent' => $this->id_parent,':active' => STATUS_ACTIVE);
        return $this->DB->Count('SELECT count(*) FROM page WHERE id_lang=:id_lang AND id_parent=:id_parent AND active=:active',$params);
    }
 
    /*
	public function GetMenuItems()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT * FROM menu WHERE id_lang=:id_lang', $params, PDO::FETCH_CLASS);
    }

    public function GetMenu($id)
    {
        $params = array(':id_menu' => $id, ':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT * FROM menu WHERE id_lang=:id_lang AND id_menu=:id_menu', $params, PDO::FETCH_ASSOC);
    }
	
    public function GetMenuChild($id)
    {
        $params = array(':id_parent' => $id, ':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT * FROM menu WHERE id_lang=:id_lang AND id_parent=:id_parent', $params, PDO::FETCH_ASSOC);
    }
	*/
	
    public function Breadcrumb($id, $level = 0)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM page WHERE id_page=:id';
                   
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);
             
        foreach($items as $item)
        {
            array_unshift($this->breadcrumb,$item);
        }
        
        foreach($items as $item)
        {
            $this->Breadcrumb($item->id_parent, $item,$level);
        }
		
    }
	
	public function Url($id, &$url)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM page WHERE id_page=:id';
                   
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);
             
        foreach($items as $item)
        {
            $url.= $item->GetTitle();
        }
        
        foreach($items as $item)
        {
            $this->Breadcrumb($item->id_parent, $url);
        }
		
    }
	
	
    public function GetParentId($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT id_page as id,id_parent FROM page WHERE id_page=:id";
		return $this->DB->Row($sql, $params);
	}

	public function GetStartPage()
	{
		$params = array(':id_lang' => Session::GetLang() );
		$sql = "SELECT * FROM page,settings WHERE page.id_page=settings.id_page AND settings.id_lang=:id_lang";
		return $this->DB->Row($sql, $params);
	}
	
    // aktualna strona lub strona startowa if parent 0
    public function GetCurrentItem()
    {
        if($this->id_parent > 0)
		{
			$params = array(':id' => $this->id_parent);
			$sql = "SELECT * FROM page WHERE id_page=:id";
	
		}else{
			
			$params = array(':id_lang' => Session::GetLang() );
			$sql = "SELECT * FROM page,settings WHERE page.id_page=settings.id_page AND settings.id_lang=:id_lang";
		}
		
		return $this->DB->Row($sql, $params);
    }

    public function Tree($item = NULL,$level = 0)
    {
        $params = array(':id_parent' => $this->id_parent, ':active' => STATUS_ACTIVE,'id_lang' => Session::GetLang());
        $sql = 'SELECT * FROM page WHERE id_parent=:id_parent AND active=:active AND id_lang=:id_lang';
        if($item == NULL)
            $item = $this;
            
        $item->items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
        
        $level++;
        foreach($item->items as $item)
        {
            $this->id_parent = $item->id_page;
            $this->Tree($item,$level);
        } 
    }
    
	
	public function GetImage()
	{
        $params = array(':id_page' => $this->id_page);
        $sql = "SELECT * FROM image,image_to_page WHERE image_to_page.id_page=:id_page AND image.id_image=image_to_page.id_image ORDER BY image.position LIMIT 1";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
	// images for page
	public function GetImages()
	{
        $params = array(':id_page' => $this->id_page);
        $sql = "SELECT * FROM image,image_to_page WHERE image_to_page.id_page=:id_page AND image.id_image=image_to_page.id_image ORDER BY image.position";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
    public function Lists()
    {
        $this->OrderFieldName = 'position';
        
        $params = array(':id_lang' => Session::GetLang(),':id_parent' => $this->id_parent,':active' => STATUS_ACTIVE);
        if($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';
        
        if($this->Limit > 0)
            $sql = 'SELECT * FROM page WHERE id_lang=:id_lang AND id_parent=:id_parent AND active=:active AND position > 0 ORDER BY '.$this->OrderFieldName.' '.$asc.' LIMIT '.$this->LimitFrom.','.$this->Limit.'';
        else
            $sql = 'SELECT * FROM page WHERE id_lang=:id_lang AND id_parent=:id_parent AND active=:active AND position > 0 ORDER BY '.$this->OrderFieldName.' '.$asc;
        
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
    }
    
}

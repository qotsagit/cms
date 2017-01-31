<?php

/**
 * menuModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class menuModel extends Model
{
	public $id;
	public $id_menu;
    public $id_parent = 0;
	public $id_region;
	public $id_lang;
	public $id_page;
	public $name;
	public $active;
    public $items;
    public $count;  //for subitems count
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetId()
	{
		return $this->id_menu;
	}

    public function GetName()
    {
        return $this->name;
    }

    public function GetActive()
    {
        return $this->active;
    }
	
	public function Insert()
	{
		$params = array
		(
			':id_lang' 		=> $this->id_lang,
			':id_region' 	=> $this->id_region,
			':id_parent' 	=> $this->id_parent,
			':id_page'		=> $this->id_page,
			':name' 		=> $this->name,
			':url' 			=> $this->url,
			':position'		=> $this->position,
			':active' 		=> $this->active
		);
	
		
		$this->DB->NonQuery('INSERT INTO menu SET id_page=:id_page, id_parent=:id_parent, id_lang=:id_lang, id_region=:id_region, name=:name, url=:url, position=:position, active=:active', $params);
	}
	
	public function Update()
	{
		$params = array
		(
			':id_menu' 		=> $this->id_menu,
		    ':id_lang' 		=> $this->id_lang,
			':id_region' 	=> $this->id_region,
            ':id_parent' 	=> $this->id_parent,
			':id_page'		=> $this->id_page,
		    ':name' 		=> $this->name,
            ':url' 			=> $this->url,
			':position'		=> $this->position,
			':active' 		=> $this->active
		);
			
		$this->DB->NonQuery('UPDATE menu SET id_page=:id_page, id_parent=:id_parent, id_lang=:id_lang, id_region=:id_region, name=:name, url=:url, position=:position, active=:active WHERE id_menu=:id_menu', $params);
		
	}
	
	public function Delete()
	{
		$params = array(':id_menu' => $this->id);
        $sql = 'SELECT * FROM menu WHERE id_menu=:id_menu';
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
       	$this->DB->NonQuery('DELETE FROM menu WHERE id_menu=:id_menu', $params);

        foreach($items as $item)
		{
			$this->DeleteItems($item->id_menu);
		}
	}
	
	public function AddParent(&$items)
    {
        $item = new menuModel();
        $item->id_menu = 0;
        $item->name = $this->Msg('_PARENT_','Parent');
        array_unshift($items,$item);
    }

	public function DeleteItems($id)
	{ 
	 	$params = array(':id_parent' => $id);
        $sql = 'SELECT * FROM menu WHERE id_parent=:id_parent';
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
       
        foreach($items as $item)
        {
			$this->DeleteItems($item->id_menu);
            $params = array(':id_menu' => $item->id_menu);
			$this->DB->NonQuery('DELETE FROM menu WHERE id_menu=:id_menu', $params);
        } 
	}
    // breadcrumb array in array (w $items)
    /*
    public function Breadcrumb($id,$item = NULL, $level = 0)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM menu WHERE id_menu=:id';
        if($item == NULL)
            $item = $this;
            
        $item->items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
        
        $level++;
        foreach($item->items as $item)
        {
            $this->Breadcrumb($item->id_parent, $item,$level);
        }
    }
    */
    // as array 1 dimension
    public function Breadcrumb($id, $level = 0)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM menu WHERE id_menu=:id';
                   
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

	public function Get($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT * FROM menu WHERE id_menu=:id";
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
    public function GetParentId($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT id_menu as id,id_parent FROM menu WHERE id_menu=:id";
		return $this->DB->Row($sql, $params);
	}
	
	public function CountAll()
    {
        $params = array(':id_lang' => Session::GetLang());
		return $this->DB->Count('SELECT count(*) FROM menu WHERE id_lang=:id_lang', $params);
    }

	public function Count()
	{
		$params = array(':id_lang' => Session::GetLang(),':id_parent' =>$this->id_parent);
		return $this->DB->Count('SELECT count(*) FROM menu  WHERE id_lang=:id_lang AND id_parent=:id_parent', $params);
	}
	
    public function All()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT * FROM menu WHERE id_lang=:id_lang', $params, PDO::FETCH_CLASS);
    }

    public function Lists()
    {
		$params = array(':id_lang' => Session::GetLang(),':id_parent' => $this->id_parent);
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
		if ($this->Limit > 0)
			$sql = 'SELECT * FROM menu WHERE id_lang=:id_lang AND id_parent=:id_parent ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
		else
			$sql = 'SELECT * FROM menu WHERE id_lang=:id_lang AND id_parent=:id_parent ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
		
		return $list = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, 'menuModel');
	}
	
	// używa formularz w <select>
    // przez referencję wypełniamy zmienną
    public function Tree($id, $id_menu, &$items)
    {
		// nie wyświetlamy menuitem aktualnie wybranego do edycji
        $params = array(':id_parent' => $id, ':id_lang' => Session::GetLang(),':id_menu' => $id_menu );
		$sql = 'SELECT * FROM menu WHERE id_parent=:id_parent AND id_lang=:id_lang AND id_menu<>:id_menu';
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
       
		foreach($items as $item)
        {
			$this->Tree($item->id_menu,$id_menu,$item->items);
        }
    }
	
}

<?php

/**
 * categoryModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class categoryModel extends Model
{
    public $id_category;
    public $id_parent;
    public $id_lang;
    public $name;

    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_category;
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
            ':id_lang'  => $this->id_lang,
            ':id_parent'=> $this->id_parent,
            ':name'     => $this->name
        ); 
        
        $this->DB->NonQuery('INSERT INTO category SET id_parent=:id_parent, id_lang=:id_lang, name=:name', $params);
        
    }

    public function Update()
    {
        $params = array
        (
            ':id_category' => $this->id_category,
            ':id_parent'=> $this->id_parent,
            ':id_lang' => $this->id_lang,
            ':name' => $this->name
        );
        
        $this->DB->NonQuery('UPDATE category SET id_parent=:id_parent, id_lang=:id_lang, name=:name WHERE id_category=:id_category', $params);
        
    }

    public function Delete()
    {
        $params = array(':id_category' => $this->id);
        $sql = 'SELECT * FROM category WHERE id_category=:id_category';
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
       	$this->DB->NonQuery('DELETE  FROM category WHERE id_category=:id_category', $params);

        foreach($items as $item)
		{	
			$this->DeleteItems($item->id_category);
		}   
    }

    public function DeleteItems($id)
	{ 
	 	$params = array(':id_parent' => $id);
        $sql = 'SELECT * FROM category WHERE id_parent=:id_parent';
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
       
        foreach($items as $item)
        {
			$this->DeleteItems($item->id_category);
            $params = array(':id_category' => $item->id_category);
			$this->DB->NonQuery('DELETE FROM category WHERE id_category=:id_category', $params);
        } 
	}


    public function Get($id)
    {
        $params = array(':id' => $id);
        return $this->DB->Query("SELECT * FROM category WHERE id_category=:id", $params, PDO::FETCH_CLASS,__CLASS__);
    }
    
    public function GetParentId($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT id_category as id,id_parent FROM category WHERE id_category=:id";
		return $this->DB->Row($sql, $params);
	}

    public function Breadcrumb($id, $level = 0)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM category WHERE id_category=:id';
                   
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

	public function AddItem($name,&$items)
    {
        $item = new self();
        $item->id_category = 0;
        $item->name = $name;
        array_unshift($items,$item);
    }
		
    public function All()
    {
        $params = array(':id_lang' => Session::GetLang());
        $sql = 'SELECT * FROM category WHERE id_lang=:id_lang';
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);
    }
       
	public function CountAll()
    {
        return $this->Count();
    }
    
	public function Count()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Count('SELECT count(*) FROM category WHERE id_lang=:id_lang', $params);
    }

    public function Lists()
    {
        $params = array(':id_lang' => Session::GetLang(),':id_parent' => $this->id_parent);
        if($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';
        
        $sql = 'SELECT * FROM category WHERE id_lang=:id_lang AND id_parent=:id_parent ORDER BY '.$this->OrderFieldName.' '.$asc.' LIMIT '.$this->LimitFrom.','.$this->Limit.'';
		
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);
    }

}

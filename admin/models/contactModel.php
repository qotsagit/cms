<?php

/**
 * contactModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class contactModel extends Model
{
	public $id;
	public $id_contact;
	public $email;
	public $first_name;
	public $last_name;
	public $active;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetId()
	{
		return $this->id_contact;
	}
	
    public function GetName()
    {
        return $this->name;
    }

	public function Get($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT * FROM contact WHERE id_contact=:id";
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
	public function Delete()
	{
		$params = array(':id_contact' => $this->id);
        $items = $this->DB->Query('DELETE FROM contact WHERE id_contact=:id_contact', $params, PDO::FETCH_CLASS, __CLASS__);
	}
	
	public function CountAll()
	{
		return $this->Count();
	}
	
	public function Count()
	{
		return $this->DB->Count('SELECT count(*) FROM contact', NULL);
	}
	
    public function All()
    {
        return $this->DB->Query('SELECT * FROM contact' , NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
		if ($this->Limit > 0)
		    $sql = 'SELECT * FROM contact ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
		else
		    $sql = 'SELECT * FROM contact ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
		
		return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
	}
	
}

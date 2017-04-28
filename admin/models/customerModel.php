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

class customerModel extends Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetId()
	{
		return $this->id_customer;
	}
	
    public function GetName()
    {
        return $this->name;
    }

	
	public function Insert()
	{
		 $params = array
		 (
            ':name'     => $this->name,
			':address'	=> $this->address,
            ':email'    => $this->email,
            ':website'  => $this->website,
            ':city'  	=> $this->city,
            ':phone'    => $this->phone,
            ':text'		=> $this->text
        );
        
        $this->DB->NonQuery('INSERT INTO customer SET name=:name, address=:address, email=:email, website=:website, city=:city, phone=:phone, text=:text', $params);
	}
	
	public function Update()
	{
		
		 $params = array
		 (
			':id'		=> $this->id_customer,
            ':name'     => $this->name,
			':address'	=> $this->address,
            ':email'    => $this->email,
            ':website'  => $this->website,
            ':city'  	=> $this->city,
            ':phone'    => $this->phone,
            ':text'		=> $this->text
        );
		 
        $this->DB->NonQuery('UPDATE customer SET name=:name, address=:address, email=:email, website=:website, city=:city, phone=:phone, text=:text WHERE id_customer=:id', $params);
	}
	
	
	public function Get($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT * FROM customer WHERE id_customer=:id";
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
	public function Delete()
	{
		$params = array(':id_customer' => $this->id);
        $items = $this->DB->Query('DELETE FROM customer WHERE id_customer=:id_customer', $params, PDO::FETCH_CLASS, __CLASS__);
	}
	
	public function CountAll()
	{
		return $this->Count();
	}
	
	public function Count()
	{
		return $this->DB->Count('SELECT count(*) FROM customer', NULL);
	}
	
    public function All()
    {
        return $this->DB->Query('SELECT * FROM customer' , NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
		if ($this->Limit > 0)
		    $sql = 'SELECT * FROM customer ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
		else
		    $sql = 'SELECT * FROM customer ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
		
		return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
	}
	
}

<?php

/**
 * newsletterModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class newsletterModel extends Model
{
	public $id;
	public $id_newsletter;
	public $start_date;
	public $end_date;
	public $name;
	public $text;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetId()
	{
		return $this->id_newsletter;
	}
	
    public function GetName()
    {
        return $this->name;
    }   

	public function Insert()
	{
		$params = array
		(
		    ':title'     	=> $this->title,
			':start_date'	=> $this->start_date,
		    ':text'     	=> $this->text
		);

		$this->DB->NonQuery('INSERT INTO newsletter SET title=:title, start_date=:start_date, text=:text  ', $params);
	}
	
	public function Update()
	{
		$params = array
		(
			':id_newsletter'=> $this->id_newsletter,	
		    ':title'     	=> $this->title,
			':start_date'	=> $this->start_date,
		    ':text'     	=> $this->text
		);
		
		print_r($params);
		
		$this->DB->NonQuery('UPDATE newsletter SET title=:title, start_date=:start_date, text=:text  WHERE id_newsletter=:id_newsletter', $params);
		
	}
	
	public function Delete()
	{
		$params = array(':id' => $this->id);
		$this->DB->NonQuery('DELETE FROM newsletter WHERE id_newsletter=:id', $params);
		return;
	}
	
	public function Get($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT * FROM newsletter WHERE id_newsletter=:id";
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
	public function CountAll()
	{
		return $this->Count();
	}
	
	public function Count()
	{
		return $this->DB->Count('SELECT count(*) FROM newsletter', NULL);
	}
	
    public function All()
    {
        return $this->DB->Query('SELECT * FROM newsletter' , NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
		if ($this->Limit > 0)
		    $sql = 'SELECT * FROM newsletter ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
		else
		    $sql = 'SELECT * FROM newsletter ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
		
		return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
	}
	
}

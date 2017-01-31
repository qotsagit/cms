<?php

/**
 * calendarModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class calendarModel extends Model
{
	public $id;
	public $id_calendar;
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
		return $this->id_calendar;
	}
	
    public function GetName()
    {
        return $this->name;
    }   

	public function Insert()
	{
		$params = array
		(
			':start_date'	=> $this->start_date,
			':end_date'		=> $this->end_date,
		    ':name'     	=> $this->name,
		    ':text'     	=> $this->text
		);

		$this->DB->NonQuery('INSERT INTO calendar SET start_date=:start_date, end_date=:end_date, name=:name, text=:text  ', $params);
	}
	
	public function Update()
	{
		$params = array
		(
		    ':id_calendar' 	=> $this->id_calendar,
			':start_date'	=> $this->start_date,
			':end_date'		=> $this->end_date,
		    ':name' 		=> $this->name,
            ':text'     	=> $this->text
		);
		
		$this->DB->NonQuery('UPDATE calendar SET start_date=:start_date, end_date=:end_date, name=:name, text=:text  WHERE id_calendar=:id_calendar', $params);
		
	}
	
	public function Delete()
	{
		$params = array(':id' => $this->id);
		$this->DB->NonQuery('DELETE FROM calendar WHERE id_calendar=:id', $params);
		return;
	}
	
	public function Get($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT * FROM calendar WHERE id_calendar=:id";
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
	public function CountAll()
	{
		return $this->Count();
	}
	
	public function Count()
	{
		return $this->DB->Count('SELECT count(*) FROM calendar', NULL);
	}
	
    public function All()
    {
        return $this->DB->Query('SELECT * FROM task' , NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
		if ($this->Limit > 0)
		    $sql = 'SELECT * FROM calendar ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
		else
		    $sql = 'SELECT * FROM calendar ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
		
		return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
	}
	
}

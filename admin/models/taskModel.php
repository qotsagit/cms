<?php

/**
 * taskModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class taskModel extends Model
{
	public $id;
	public $id_task;
	public $id_user;
	public $name;
	public $active;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GetId()
	{
		return $this->id_task;
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
		    ':id_user'  => $this->id_user,
		    ':name'     => $this->name,
		    ':text'     => $this->text,
            ':active'   => $this->active
            //':start_date' => $this->start_date
            //':end_date' => $this->end_date
		);

		$this->DB->NonQuery('INSERT INTO task SET id_user=:id_user, name=:name, active=:active, text=:text, start_date=now() ', $params);
	}
	
	public function Update()
	{
		$params = array
		(
		    ':id_task' 	=> $this->id_task,
		    ':id_user' 	=> $this->id_user,
		    ':name' 	=> $this->name,
            ':text'     => $this->text,
		    ':active' 	=> $this->active
            //':start_date' => $this->start_date,
            //':end_date' => $this->end_date
		);
		
		$this->DB->NonQuery('UPDATE task SET id_user=:id_user, name=:name, active=:active, text=:text WHERE id_task=:id_task', $params);
		
	}
	
	public function Delete()
	{
		$params = array(':id' => $this->id);
		$this->DB->NonQuery('DELETE FROM task WHERE id_task=:id', $params);
		return;
	}
	
	public function Get($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT * FROM task WHERE id_task=:id";
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
	}
	
	public function CountAll()
	{
		return $this->Count();
	}
	
	public function Count()
	{
		return $this->DB->Count('SELECT count(*) FROM task', NULL);
	}
	
    public function All()
    {
        return $this->DB->Query('SELECT * FROM task' , NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
		$params = array(':id_lang' => Session::GetLang(),':id_parent' => $this->id_parent);
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
		if ($this->Limit > 0)
		    $sql = 'SELECT * FROM task ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
		else
		    $sql = 'SELECT * FROM task ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
		
		return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
	}
	
}

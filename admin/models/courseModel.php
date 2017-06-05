<?php

/**
 * courseModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class courseModel extends Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_course;
    }

    public function Insert()
    {
        $params = array
        (
            ':name'         => $this->name,
            ':start_date'   => $this->start_date,
            ':end_date'     => $this->end_date,
            ':max_users'    => $this->max_users,
            ':text'         => $this->text
        );

        $this->DB->NonQuery('INSERT INTO course SET name=:name, start_date=:start_date, end_date=:end_date, max_users=:max_users, text=:text', $params);
    }

    public function Update()
    {
    
        $params = array
        (
            ':id'           => $this->id_course,
            ':name'         => $this->name,
            ':start_date'   => $this->start_date,
            ':end_date'     => $this->end_date,
            ':max_users'    => $this->max_users,
            ':text'         => $this->text
        );
        
        $this->DB->NonQuery('UPDATE course SET name=:name, start_date=:start_date, end_date=:end_date, max_users=:max_users, text=:text WHERE id_course=:id', $params);
        
    }
    
    public function Delete()
    {
        $params = array(':id' => $this->id);
        $this->DB->NonQuery('DELETE FROM course WHERE id_course=:id', $params);
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM course WHERE id_course=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }
  
    public function CountAll()
    {
        $params = array(':search' => '%'.Session::GetSearch().'%');
        return $this->DB->Count('SELECT count(*) FROM course WHERE name LIKE :search', $params);
    }  
    
    public function Count()
    {
        $params = array(':search' => '%'.Session::GetSearch().'%');
        return $this->DB->Count('SELECT count(*) FROM course WHERE name LIKE :search', $params);
    }

    // course users
    public function Users()
    {
        $sql = 'SELECT * FROM user';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,__CLASS__);
    }
        
    public function Lists()
    {
        $params = array(':search' => '%'.Session::GetSearch().'%');
        if ($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';

        if ($this->Limit > 0)
            $sql = 'SELECT * FROM course WHERE name LIKE :search ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM course ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
    }

}

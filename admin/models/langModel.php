<?php

/**
 * langModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class langModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_lang;
    }
    
    public function GetActive()
    {
        return $this->active;
    }
    
    public function Insert()
    {
        $params = array
        (
            ':name' => $this->name,
            ':code' => $this->code,
            ':active' => $this->active
        );
        
        $this->DB->NonQuery('INSERT INTO lang SET name=:name, code=:code, active=:active', $params);
        
        //update roles
        $id_lang = $this->DB->LastInsertId();
        
        $params = array(':id' => DEFAULT_LANG_ID);
        $items = $this->DB->Query("SELECT * FROM role WHERE id_lang=:id", $params,PDO::FETCH_CLASS);
        
        foreach($items as $item)
        {
            $params = array(':id_role' => $item->id_role,':id_lang' => $id_lang,':name' => $item->name, ':text' => $item->text);
            $this->DB->NonQuery('INSERT INTO role SET id_role=:id_role,id_lang=:id_lang, name=:name,text=:text', $params);
        }
        
        return;
    }
    
    public function Update()
    {
        $params = array
        (
            ':id_lang'  => $this->id_lang,
            ':name'     => $this->name,
            ':code'     => $this->code,
            ':active'   => $this->active
        );
        
        $this->DB->NonQuery('UPDATE lang SET name=:name,code=:code, active=:active WHERE id_lang=:id_lang', $params);
        return;
    }

    public function Delete()
    {
        $params = array(':id_lang'=> $this->id);
        $this->DB->NonQuery('DELETE FROM lang WHERE id_lang=:id_lang', $params);
        $this->DB->NonQuery('DELETE FROM msg WHERE id_lang=:id_lang', $params);
        $this->DB->NonQuery('DELETE FROM role WHERE id_lang=:id_lang', $params);
        return;
    }
    
    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM lang WHERE id_lang=:id";
        return $this->DB->Query($sql, $params,PDO::FETCH_CLASS);
    }

    public function CountAll()
    {
        return $this->Count();
    }
    
    public function Count()
    {
        $sql = 'SELECT count(*) FROM lang';
        return $this->DB->Count($sql, NULL);
    }

    public function All()
    {
        $sql = 'SELECT * FROM lang';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,'Lang');
    }
    
    public function Lists()
    {   
       
        if($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';
        
        if($this->Limit > 0)
            $sql = 'SELECT * FROM lang ORDER BY '.$this->OrderFieldName.' '.$asc.' LIMIT '.$this->LimitFrom.','.$this->Limit.'';
        else
            $sql = 'SELECT * FROM lang ORDER BY '.$this->OrderFieldName.' '.$asc;
        
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
    }
    
}

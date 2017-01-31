<?php

/**
 * msgModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class msgModel extends Model
{
    
    public $id_msg;
    public $id_lang;
    public $user_value;
    public $default_value;

    public function __construct()
    {
        parent::__construct();
    }
 
    public function GetId()
    {
        return $this->id_msg;
    }
     
    public function Update()
    {
        $params = array(':id_msg'=> $this->id_msg, ':user_value' => $this->user_value);
        $this->DB->NonQuery('UPDATE msg SET user_value=:user_value WHERE id_msg=:id_msg', $params);
        return;
    }

    public function Delete($id_user)
    {
        $params = array(':id_user'=> $id_user);
        $this->DB->NonQuery('DELETE FROM msg WHERE id_user=:id_user', $params);
        return;
    }
    
    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM msg WHERE id_msg=:id';
        return $this->DB->Query($sql, $params,PDO::FETCH_CLASS);
    }

    public function CountAll()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Count('SELECT count(*) FROM msg WHERE id_lang=:id_lang',$params);
    }
    
    public function Count()
    {
        $params = array(':id_lang' => Session::GetLang(),':search' => '%'.Session::GetSearch().'%');
        return $this->DB->Count('SELECT count(*) FROM msg WHERE id_lang=:id_lang AND (const LIKE :search OR user_value LIKE :search OR default_value LIKE :search)',$params);
    }

    public function AllValues()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT const,value FROM msg WHERE id_lang=:id_lang', $params, PDO::FETCH_KEY_PAIR);
    }
    
    public function AllDefaultValues()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT const,default_value FROM msg WHERE id_lang=:id_lang', $params, PDO::FETCH_KEY_PAIR);
    }
    
    
    public function Lists()
    {   
        $params = array(':id_lang' => Session::GetLang(),':search' => '%'.Session::GetSearch().'%');
        if($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';
        
        if($this->Limit > 0)
            $sql = 'SELECT * FROM msg WHERE id_lang=:id_lang AND (const LIKE :search OR user_value LIKE :search OR default_value LIKE :search) ORDER BY '.$this->OrderFieldName.' '.$asc.' LIMIT '.$this->LimitFrom.','.$this->Limit.'';
        else
            $sql = 'SELECT * FROM msg WHERE id_lang=:id_lang ORDER BY '.$this->OrderFieldName.' '.$asc;
        
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, 'msgModel');
    }
    
}

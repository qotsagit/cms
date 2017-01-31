<?php

/**
 * settingsModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class settingsModel extends Model
{
    public $id;
    public $id_block;
    public $id_start_page;
    public $id_start_lang;
    public $url;
    public $meta_keywords;
    public $page_email;

    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_block;
    }

    public function Insert()
    {
        
        $params = array
        (
            ':id_lang' => Session::GetLang(),
            ':id_page' => $this->id_page
        );

        
        $this->DB->NonQuery('INSERT INTO settings SET id_lang=:id_lang, id_page=:id_page', $params);
    }
    
    public function Update()
    {
        $params = array
        (
            ':id_lang' => Session::GetLang(),
            ':id_page' => $this->id_page
        );
        
        $this->DB->NonQuery('UPDATE settings SET id_page=:id_page WHERE id_lang=:id_lang', $params);
    }
    
    public function Exists()
    {
        $params = array(':id_lang' => Session::GetLang());   
        return $this->DB->Row('SELECT * FROM settings WHERE id_lang=:id_lang',$params);
    }
    
    public function Delete()
    {
        $params = array(':id_lang' => Session::GetLang());
        $this->DB->NonQuery('DELETE FROM settings WHERE id_lang=:id_lang', $params);
        return;
    }

    public function Get()
    {
        $params = array(':id_lang' => Session::GetLang());
        $sql = "SELECT * FROM settings WHERE id_lang=:id_lang";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }
  
    public function CountAll()
    {
        return $this->Count();
    }

}

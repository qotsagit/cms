<?php

/**
 * roleModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class roleModel extends Model
{
    public $id_role;
    public $name;

    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function Insert()
    {

        $params = array(':id' => DEFAULT_LANG_ID);
        $items = $this->DB->Query("SELECT * FROM lang", $params,PDO::FETCH_CLASS);
        $max = $this->DB->Max('id_role','role');

        $max->Max +=1;
        
        foreach($items as $item)
        {
            $params = array(':name' => $this->name,':id_lang' => $item->id_lang,':id_role' => $max->Max);
            $this->DB->NonQuery('INSERT INTO role SET name=:name,id_role=:id_role,id_lang=:id_lang', $params);
        }
    }

    public function Update()
    {
        $params = array(
            ':id_role' => $this->id_role,
            ':name' => $this->name
        );
        
        $this->DB->NonQuery('UPDATE role SET name=:name WHERE id=:id_role', $params);
        return;
    }

    public function Delete()
    {
        $params = array(':id_user' => $this->id_user);
        $this->DB->NonQuery('DELETE  FROM role WHERE id_user=:id_user', $params);
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        return $this->DB->Query("SELECT * FROM role WHERE id=:id", $params, PDO::FETCH_CLASS,'roleModel');
    }

    public function CountAll()
    {
        return $this->Count();
    }
    
    public function Count()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Count('SELECT count(*) FROM role WHERE id_lang=:id_lang', $params);
    }

    public function All()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT * FROM role WHERE id_lang=:id_lang', $params, PDO::FETCH_CLASS,'roleModel');
    }
    
    public function Lists()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT * FROM role WHERE id_lang=:id_lang', $params, PDO::FETCH_CLASS,'roleModel');
    }

}

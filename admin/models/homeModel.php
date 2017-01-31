<?php

/**
 * homeModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class homeModel extends Model
{

    public $id_category;
    public $id_lang;
    public $name;

    public function __construct()
    {
        parent::__construct();
    }

    public function Insert()
    {
        $params = array(
            ':name' => $this->name,
            ':id_lang' => $this->id_lang
        ); 
        
        $this->DB->NonQuery('INSERT INTO category SET id_lang=:id_lang, name=:name', $params);
    }

    public function Update()
    {
        $params = array(
            ':id_category' => $this->id_category,
            ':name' => $this->name,
            ':id_lang' => $this->id_lang
        );
        
        $this->DB->NonQuery('UPDATE category SET id_lang=:id_lang,name=:name WHERE id_category=:id_category', $params);
        return;
    }

    public function Delete()
    {
        $params = array(':id_user' => $this->id_user);
        $this->DB->NonQuery('DELETE  FROM category WHERE id_user=:id_user', $params);
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM user WHERE id_user=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }

    public function Count()
    {
        $sql = 'SELECT * FROM category';
        return $this->DB->Count($sql, NULL);
    }

    public function Lists()
    {
        if($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';
        
        $sql = 'SELECT * FROM category ORDER BY '.$this->OrderFieldName.' '.$asc.' LIMIT '.$this->LimitFrom.','.$this->Limit.'';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,'Category');
    }

}

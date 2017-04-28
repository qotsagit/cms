<?php

/**
 * blockModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class blockModel extends Model
{
    public $id;
    public $id_block;
    public $id_user;
    public $id_tpl_region;
    public $position;
    public $id_lang;
    public $content_type;
    public $title;
    public $text;
    public $img;
    public $show_type;
    public $show_url;
    public $added_time;
    public $active;

    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_block;
    }

    public function GetActive()
    {
        return $this->active;
    }

    public function Insert()
    {
        $params = array
        (
            ':id_lang' => $this->id_lang,
            ':id_user' => $this->id_user,
            ':id_region' => $this->id_region,
            ':title' => $this->title,
            ':text' => $this->FilterTextFromEditor($this->text),
            ':active' => $this->active
        );

        $this->DB->NonQuery('INSERT INTO block SET id_lang=:id_lang,id_user=:id_user,id_region=:id_region,title=:title,text=:text,added_time=now(),active=:active', $params);
    }

    public function Update()
    {
    
        $params = array
        (
            ':id_user' => $this->id_user,
            ':id_lang' => $this->id_lang,
            ':id_block' => $this->id_block,
            ':id_region' => $this->id_region,
            ':title' => $this->title,
            ':text' => $this->FilterTextFromEditor($this->text),
            ':active' => $this->active
        );

        $this->DB->NonQuery('UPDATE block SET id_user=:id_user,id_lang=:id_lang,id_region=:id_region,title=:title,text=:text,active=:active WHERE id_block=:id_block', $params);
        
    }
    
    public function Delete()
    {
        $params = array(':id_block' => $this->id);
        $this->DB->NonQuery('DELETE FROM block WHERE id_block=:id_block', $params);
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM block WHERE id_block=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }
  
    public function CountAll()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Count('SELECT count(*) FROM block WHERE id_lang=:id_lang', $params);
    }  
    
    public function Count()
    {
        $params = array(':id_lang' => Session::GetLang(),':search' => '%'.Session::GetSearch().'%');
        return $this->DB->Count('SELECT count(*) FROM block WHERE id_lang=:id_lang AND title LIKE :search', $params);
    }

    public function Lists()
    {
        $params = array(':id_lang' => Session::GetLang(),':search' => '%'.Session::GetSearch().'%');
        if ($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';

        if ($this->Limit > 0)
            $sql = 'SELECT * FROM block WHERE id_lang=:id_lang AND title LIKE :search ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM block WHERE id_lang=:id_lang ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
    }

}

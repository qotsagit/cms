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

class placeModel extends Model
{
    public $id;
    public $id_place;
    public $title;
    public $text;
    public $lon;
    public $lat;
    public $zoom;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_place;
    }

    public function Insert()
    {
        $params = array
        (
            ':title'    => $this->title,
            ':text'     => $this->text,
            ':lon'      => $this->lon,
            ':lat'      => $this->lat,
            ':zoom'     => $this->zoom
        );

        $this->DB->NonQuery('INSERT INTO place SET title=:title, text=:text, lon=:lon, lat=:lat, zoom=:zoom', $params);
    }

    public function Update()
    {

        $params = array
        (
            ':id_place' => $this->id_place,
            ':title'    => $this->title,
            ':text'     => $this->text,
            ':lon'      => $this->lon,
            ':lat'      => $this->lat,
            ':zoom'     => $this->zoom
        );

        $this->DB->NonQuery('UPDATE place SET title=:title, text=:text, lon=:lon, lat=:lat, zoom=:zoom WHERE id_place=:id_place', $params);
        
    }
    
    public function Delete()
    {
        $params = array(':id' => $this->id);
        print_r($params);
        $this->DB->NonQuery('DELETE FROM place WHERE id_place=:id', $params);
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM place WHERE id_place=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }
  
    public function CountAll()
    {
        return $this->DB->Count('SELECT count(*) FROM place ', NULL);
    }  
    
    public function Count()
    {
        $params = array(':search' => '%'.Session::GetSearch().'%');
        return $this->DB->Count('SELECT count(*) FROM place WHERE title LIKE :search', $params);
    }

    public function Lists()
    {
        $params = array(':search' => '%'.Session::GetSearch().'%');
        if ($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';

        if ($this->Limit > 0)
            $sql = 'SELECT * FROM place WHERE title LIKE :search ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM place WHERE title LIKE :search ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
    }

}

<?php

/**
 * placeModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class placeModel extends Model
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function All()
    {
        $sql = 'SELECT * FROM place ORDER BY title';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
    }
       
    
    //zwracamy model ala json dla kontrolera contact, lista wszystkich miejsc wpisanych w cmsie
    public function Json()
    {
        $sql = 'SELECT * FROM place ORDER BY title';
        return  json_encode($this->DB->Query($sql, NULL, PDO::FETCH_ASSOC));
    }

    
    public function Lists()
    {
        $sql = 'SELECT * FROM place ORDER BY title';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);

    }
    
}

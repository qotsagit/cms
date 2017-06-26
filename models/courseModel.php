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
    
    public function Available()
    {
        $sql = 'SELECT * FROM course WHERE DATE(start_date) > DATE(now()) ORDER BY start_date';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,__CLASS__);
    }
    
}

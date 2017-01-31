<?php

/**
 * ideaModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class ideaModel extends Model
{
    public $Limit;

    public function __construct()
    {
        parent::__construct();
    }

    public function Save($nick, $first_name, $last_name, $mobile_phone)
    {
        $params = array(':nick' => $nick);
        $this->db->NonQuery('INSERT INTO idea SET nick=:nick', $params);
        return;
    }

    public function GetItem($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM idea WHERE id=:id";
        return $this->db->Query($sql, NULL);
    }

    public function Count()
    {
        $sql = 'SELECT * FROM idea';
        return $this->db->Count($sql, NULL);
    }

    public function Lists()
    {
        $sql = 'SELECT * FROM idea LIMIT 25';
        return $this->db->Query($sql, NULL, PDO::FETCH_CLASS);
    }

}

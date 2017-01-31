<?php
/**
 * buyModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class buyModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_user;
    }

    public function Insert()
    {
        $params = array
        (
            ':remote_addr'  => $this->remote_addr,
            ':tr_id'        => $this->tr_id,
            ':tr_date'      => $this->tr_date,
            ':tr_crc'       => $this->tr_crc,
            ':tr_amount'    => $this->tr_amount,
            ':tr_paid'      => $this->tr_paid,
            ':tr_desc' 	    => $this->tr_desc,
            ':tr_status'    => $this->tr_status,
            ':tr_error' 	=> $this->tr_error,
            ':tr_email' 	=> $this->tr_email,
            ':md5sum' 	    => $this->md5sum,
            ':test_mode' 	=> $this->test_mode,
            ':wallet'       => $this->wallet,

        );

        $this->DB->NonQuery('INSERT INTO buy SET remote_addr=:remote_addr,tr_id=:tr_id,tr_date=:tr_date,tr_crc=:tr_crc,tr_amount=:tr_amount,tr_paid=:tr_paid,tr_desc=:tr_desc,tr_status=:tr_status,tr_error=:tr_error,tr_email=:tr_email,md5sum=:md5sum,test_mode=:test_mode,wallet=:wallet', $params);
    }

    public function Delete()
    {
        $params = array(':id_user' => $this->id);
        $this->DB->NonQuery('DELETE  FROM user WHERE id_user=:id_user', $params);
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM user WHERE id_user=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }
    
    public function CountAll()
    {
        return $this->Count();
    }
    
    public function Count()
    {
        $sql = 'SELECT * FROM user WHERE built_in=0';
        return $this->DB->Count($sql, NULL);
    }

    public function All()
    {
        $sql = 'SELECT * FROM user';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
        if ($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';

        if ($this->Limit > 0)
            $sql = 'SELECT * FROM user WHERE built_in=0 ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM user WHERE built_in=0 ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
    }

}

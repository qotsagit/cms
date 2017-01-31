<?php
/**
 * contactModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class contactModel extends Model
{

    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $subject;
    public $phone;
    public $message;
    public $newsletter;
    
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
            ':first_name'   => $this->first_name,
            ':last_name'    => $this->last_name,
            ':email'        => $this->email,
            ':subject'      => $this->subject,
            ':phone'        => $this->phone,
            ':message'      => $this->message,
            ':newsletter'   => $this->newsletter
        );

        $this->DB->NonQuery('INSERT INTO contact SET first_name=:first_name, last_name=:last_name, email=:email, subject=:subject, phone=:phone, message=:message, newsletter=:newsletter, date=now()', $params);
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

<?php
/**
 * userModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class userModel extends Model
{
    public $id;
    public $id_customer;
    public $customer_type;
    public $password;
    public $email;
    public $first_name;
    public $last_name;
    public $phone;
    public $company;
    public $vat;
    public $address;
    public $zip_code;
    public $city;
    public $country;
    public $confirmed;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_customer;
    }   

    public function Insert()
    {
        $params = array
        (
            ':email'            => $this->email,
            ':first_name'       => $this->first_name,
            ':last_name'        => $this->last_name,
            ':phone'            => $this->phone
        );

        $this->DB->NonQuery('INSERT INTO user SET email=:email, first_name=:first_name, last_name=:last_name, phone=:phone ', $params);
    }

    public function EmailExists()
    {
        $params = array(':email' => $this->email);
        return $this->DB->Row('SELECT * FROM user WHERE email=:email',$params);
    }
    
    public function Delete()
    {
        $params = array(':id_user' => $this->id);
        $this->DB->NonQuery('DELETE  FROM customer WHERE id_user=:id_user', $params);
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

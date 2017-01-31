<?php

/**
 * registerModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class RegisterModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function RegisterUser($email)
    {
        $params = array(':email' => $email);

        if(!$this->db->NonQuery('INSERT INTO user SET email=:email, register_date=now()', $params))
            return false;
        
        $params = array(':id_user'=>  $this->LastInsertId());
        if(! $this->db->NonQuery('INSERT INTO register SET id_user=:id_user, date=now()', $params))
            return false;
        
        return true;
    }

    public function CheckEmailExists($email)
    {
        $params = array(':email' => $email);

        if ($this->db->Count('SELECT * FROM user WHERE email=:email', $params) > 0)
            return true;
        else
            return false;
    }

}

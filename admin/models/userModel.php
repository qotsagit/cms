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
    public $id_user;
    public $id_lang;
    public $id_role;
    public $nick;
    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $avatar;
    public $active;


    public function __construct()
    {
        parent::__construct();
        $this->OrderFieldName = 'nick';
    }

    public function GetId()
    {
        return $this->id_user;
    }
    
    public function GetName()
    {
        return $this->nick;
    }
    
    public function GetTitle()
    {
        return $this->nick;
    }

    public function GetActive()
    {
        return $this->active;
    }

    public function Insert()
    {
        // password md5 w kontrolerze
        $params = array(
            ':id_lang'      => $this->id_lang,
            ':id_role'      => $this->id_role,
            ':nick'         => $this->nick,
            ':email'        => $this->email,
            ':password'     => $this->password,
            ':first_name'   => $this->first_name,
            ':last_name'    => $this->last_name,
            ':avatar'       => $this->avatar,
            ':active'       => $this->active,
            ':type'         => USER_TYPE_USER
        );
        
        
        $this->DB->NonQuery('INSERT INTO user SET avatar=:avatar,id_lang=:id_lang,id_role=:id_role,nick=:nick,email=:email,first_name=:first_name,last_name=:last_name,password=:password,active=:active,type=:type', $params);
    }

    public function Update()
    {
        // password md5 w kontrolerze
        $params = array(
            ':id_user'      => $this->id_user,
            ':id_lang'      => $this->id_lang,
            ':id_role'      => $this->id_role,
            ':nick'         => $this->nick,
            ':email'        => $this->email,
            ':password'     => $this->password,
            ':first_name'   => $this->first_name,
            ':last_name'    => $this->last_name,
            ':avatar'       => $this->avatar,
            ':active'       => $this->active
            
        );

        $this->DB->NonQuery('UPDATE user SET avatar=:avatar,id_role=:id_role,id_lang=:id_lang,nick=:nick,email=:email,first_name=:first_name,last_name=:last_name,password=:password,active=:active WHERE id_user=:id_user', $params);
        
    }

    // for writing user settings
    public function UpdateSettings()
    {
        $params = array(
            ':id_user'      => $this->id_user,
            ':id_lang'      => $this->id_lang,
            ':nick'         => $this->nick,
            ':email'        => $this->email,
            ':first_name'   => $this->first_name,
            ':last_name'    => $this->last_name
        );

        $this->DB->NonQuery('UPDATE user SET id_lang=:id_lang,nick=:nick,email=:email,first_name=:first_name,last_name=:last_name WHERE id_user=:id_user', $params);
        
    }

    public function UpdatePassword()
    {
        $params = array(':password' => md5($this->password), ':id_user' => $this->id_user);
        $this->DB->NonQuery('UPDATE user SET password=:password WHERE id_user=:id_user ', $params);
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
        $params = array(':type' => USER_TYPE_USER);
        return $this->DB->Count('SELECT count(*) FROM user WHERE built_in=0 AND type=:type', $params);
    }

    public function All()
    {
        $sql = 'SELECT * FROM user';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
        $params = array(':type' => USER_TYPE_USER);
        if ($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';

        if ($this->Limit > 0)
            $sql = 'SELECT * FROM user WHERE built_in=0 AND type=:type ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM user WHERE built_in=0 AND type=:type ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
    }

}

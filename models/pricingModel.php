<?php

/**
 * pricingModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class pricingModel extends Model
{
    
    public $price;
    public $name;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function Insert()
    {
         $params = array(
            ':id_lang'      => $this->id_lang,
            ':id_role'      => $this->id_role,
            ':nick'         => $this->nick,
            ':email'        => $this->email,
            ':password'     => md5($this->password),
            ':first_name'   => $this->first_name,
            ':last_name'    => $this->last_name,
            ':avatar'       => $this->avatar,
            ':active'       => $this->active,
            ':type'         => $this->type
    
        );

        $this->DB->NonQuery('INSERT INTO user SET avatar=:avatar,id_lang=:id_lang,id_role=:id_role,nick=:nick,email=:email,first_name=:first_name,last_name=:last_name,password=:password,active=:active,type=:type', $params);
                       
        return true;
    }


}

<?php

/**
 * Alter
 * 
 * @category   Libs
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */


class Alter
{

    public $User;
    public $DB;

    public function __construct()
    {
        $this->DB = Database::getInstance();        
    }

    public function AsString()
    {


    }
}

<?php

/**
 * statusModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

//model jest tablicą
class alterModel extends Model
{
    public $version;
    public $sql;

    
    public function __construct($version , $sql )
    {
        parent::__construct();
        $this->version = $id;
        $this->sql = $sql;
    }
    
    public function GetVersion()
    {
        return $this->version;
    }

    public function GetSql()
    {
        return $this->sql;
    }

    public function All()
    {
        return array
        (
            new alterModel(2,"ALTER TABLE `image` ADD `size` INT NOT NULL AFTER `name`"),
            new alterModel(2,"ALTER TABLE `menu` ADD `position` INT NOT NULL AFTER `url`"),
            new alterModel(2,"ALTER TABLE `image` ADD `width` INT NOT NULL AFTER `size`"),
            new alterModel(2,"ALTER TABLE `image` ADD `height` INT NOT NULL AFTER `width`"),
            new alterModel(2,"ALTER TABLE `page` CHANGE `img` `img` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL")
        );
    }
}








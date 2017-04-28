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


    public function __construct()
    {
    
    }

    public function AsString()
    {
	
	
	


    }

    public function Update()
    {
	$alter = new alterModel();
	$items = $alter->All();

	foreach($items as $item)
	{
	    $item->Update();
	}
    
    }
}


/**
 * alterModel
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


    public function __construct($version = 0 , $sql = '' )
    {
        parent::__construct();
        $this->version = $version;
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
    

    public function Update()
    {

	if($this->version > 0)
	{
	    print $this->sql;
	    print "\n";
	    $this->DB = Database::getInstance();
	    $this->DB->Exception = false;
	    $this->DB->Query($this->sql,NULL);
	    print "\n";
	}
    }

    public function All()
    {
        return array
        (
            new alterModel(2,"ALTER TABLE `image` ADD `size` INT NOT NULL AFTER `name`"),
            new alterModel(2,"ALTER TABLE `menu` ADD `position` INT NOT NULL AFTER `url`"),
            new alterModel(2,"ALTER TABLE `image` ADD `width` INT NOT NULL AFTER `size`"),
            new alterModel(2,"ALTER TABLE `image` ADD `height` INT NOT NULL AFTER `width`"),
            new alterModel(2,"ALTER TABLE `page` CHANGE `img` `img` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL"),
            new alterModel(2,"ALTER TABLE `newsletter` ADD `active` TINYINT NOT NULL AFTER `text`"),
			new alterModel(2,"ALTER TABLE `menu` CHANGE `position` `position` INT NULL DEFAULT NULL;"),
			new alterModel(2,"ALTER TABLE `customer` ADD `phone` VARCHAR(64) NOT NULL AFTER `nip`;"),
        );
    }
}

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
class activeModel extends Model
{
    public $id_active;
    public $name;
    public $active;

    
    public function __construct($id = STATUS_ACTIVE, $name = '' , $active = true )
    {
        parent::__construct();
        $this->id_active = $id;
        $this->name = $name;
        $this->active = $active;        
    }
    
    public function GetId()
    {
        return $this->id_active;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        // a takie myki triki żeby nie dublować danych
        $this->name = $this->Msg('_ACTIVE_','Active');
        return array
        (
            $this,
            new activeModel(STATUS_NOT_ACTIVE,$this->Msg('_NOT_ACTIVE_','Not Active'),false)
        );
    }
}

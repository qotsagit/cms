<?php

/**
 * statusExtraModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

//model jest tablicą
class statusExtraModel extends Model
{
    public $id_status;
    public $name;
    public $active;
    
    public function __construct($id = STATUS_EXTRA_IMAGE, $name = '')
    {
        parent::__construct();
        $this->id_status = $id;
        $this->name = $name;
    
    }
    
    public function GetId()
    {
        return $this->id_status;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {

        return array
        (
            new statusExtraModel(STATUS_EXTRA_NOT_ACTIVE,$this->Msg('_NOT_CHOOSEN_','Not Choosen')),
            new statusExtraModel(STATUS_EXTRA_IMAGE,$this->Msg('_ACTIVE_IMAGES_','Only Images')),
            new statusExtraModel(STATUS_EXTRA_LOGO,$this->Msg('_ACTIVE_LOGOS_','Only Logos')),
            new statusExtraModel(STATUS_EXTRA_IMAGE_LOGO,$this->Msg('_ACTIVE_IMAGES_LOGOS_','Images & Logos'))
        );
    }
}

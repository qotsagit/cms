<?php

/**
 * contentTypeModel
 * 
 * @category    Model
 * @package     CMS
 * @author      Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright   2016 maxkod.pl
 * @version     1.0
 */

//model jest tablicą
class contentTypeModel extends Model
{
    public $id_type;
    public $name;
    public $active;

    
    public function __construct($id = CONTENT_PAGE , $name =''  , $active = true )
    {
        parent::__construct();
        $this->id_type = $id;
        $this->name = $name;
        $this->active = $active;        
    }
    
    public function GetId()
    {
        return $this->id_type;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        return array
        (
            new contentTypeModel(CONTENT_PAGE,$this->Msg('_PAGE_','Page')),
            new contentTypeModel(CONTENT_PORTFOLIO,$this->Msg('_PORTFOLIO_','Portfolio')),
            new contentTypeModel(CONTENT_NEWS,$this->Msg('_NEWS_','News'))
        );
    }
}

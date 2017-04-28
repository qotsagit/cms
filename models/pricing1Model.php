<?php

/**
 * colorModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

 class colorModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new colorModel(0,'Black'),
            new colorModel(1,'Silver'),
            new colorModel(2,'Red'),
            new colorModel(3,'Gold'),
            new colorModel(4,'Green'),
            new colorModel(5,'Violet'),
            new colorModel(6,'Blue'),
            new colorModel(7,'Orange')
        );
    }
 
    private function All_PL()
    {

        return array
        (
            new colorModel(0,'Czarny'),
            new colorModel(1,'Srebrny'),
            new colorModel(2,'Czerwony'),
            new colorModel(3,'Złoty'),
            new colorModel(4,'Zielony'),
            new colorModel(5,'Fioletowy'),
            new colorModel(6,'Niebieski'),
            new colorModel(7,'Pomarańczowy')
        );
    }
  
 }

 /**
 * wheelModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */


 
 class wheelModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new wheelModel(0,'koła szosowe/trekkingowe'),
            new wheelModel(1,'koła mtb')
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new wheelModel(0,'koła szosowe/trekkingowe'),
            new wheelModel(1,'koła mtb')
        );
    }
  
 }
 
 /**
 * sizeModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

 
 class sizeModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        return array
        (
            new sizeModel(0,'26"'),
            new sizeModel(1,'27,5"'),
            new sizeModel(2,'29"')
        );
    }
     
 }
 
 /**
 * brakesModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

  
 class brakesModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new brakesModel(0,'tarczowe'),
            new brakesModel(1,'szczękowe')
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new brakesModel(0,'tarczowe'),
            new brakesModel(1,'szczękowe')
        );
    }
  
 }
 
 /**
 * mountingModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 
 class mountingModel extends Model
 {
    
    public $id_brake;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new mountingModel(0,'centerlock'),
            new mountingModel(1,'6 śrub')
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new mountingModel(0,'centerlock'),
            new mountingModel(1,'6 śrub')
        );
    }
  
 }


 /**
 * purposeMTBModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

 class purposeMTBModel extends Model
 {
    
    public $id_brake;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new purposeMTBModel(0,'Cross country ( xc, maraton )'), 
            new purposeMTBModel(1,'All mountain'),
            new purposeMTBModel(2,'Enduro'),
            new purposeMTBModel(3,'Freeride/downhill'),
            new purposeMTBModel(4,'Fat bike/ big ride'), 
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new purposeMTBModel(0,'Cross country ( xc, maraton )'), 
            new purposeMTBModel(1,'All mountain'),
            new purposeMTBModel(2,'Enduro'),
            new purposeMTBModel(3,'Freeride/downhill'),
            new purposeMTBModel(4,'Fat bike/ big ride'), 
        );
    }
  
 }

/**
 * purposeRoadModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

 class purposeRoadModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new purposeRoadModel(0,'Jazda szosowa w różnych warunkach'), 
            new purposeRoadModel(1,'Jazda po górach'),
            new purposeRoadModel(2,'Cyclo cross'),
            new purposeRoadModel(3,'Triathlon/TT'),
            new purposeRoadModel(4,'Koła treningowe'), 
            new purposeRoadModel(5,'Koła startowe'),
            new purposeRoadModel(6,'Koła trekkingowe')
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new purposeRoadModel(0,'Jazda szosowa w różnych warunkach'), 
            new purposeRoadModel(1,'Jazda po górach'),
            new purposeRoadModel(2,'Cyclo cross'),
            new purposeRoadModel(3,'Triathlon/TT'),
            new purposeRoadModel(4,'Koła treningowe'), 
            new purposeRoadModel(5,'Koła startowe'),
            new purposeRoadModel(6,'Koła trekkingowe')
        );
    }
  
 }

 /**
 * tireRoadModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 
 
 class tireModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new tireModel(0,'opona typu clincher/tubuless ready'),
            new tireModel(1,'szytka')
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new tireModel(0,'opona typu clincher/tubuless ready'),
            new tireModel(1,'szytka')
        );
    }
  
 }
/**
 * axisFrontModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 
 class axisFrontModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
            new axisFrontModel(0,'5/100 Szybkozamykacz'),
            new axisFrontModel(1,'015/100 Thru axle'),
            new axisFrontModel(2,'15/110 Predective steering dla Rock shox rs1'),
            new axisFrontModel(3,'15/110 Boost'),
            new axisFrontModel(4,'215/150 Thru axle'),
            new axisFrontModel(5,'220/110 Thru axle') 
        );
    }
 
    private function All_PL()
    {
        return array
        (
            new axisFrontModel(0,'5/100 Szybkozamykacz'),
            new axisFrontModel(1,'015/100 Thru axle'),
            new axisFrontModel(2,'15/110 Predective steering dla Rock shox rs1'),
            new axisFrontModel(3,'15/110 Boost'),
            new axisFrontModel(4,'215/150 Thru axle'),
            new axisFrontModel(5,'220/110 Thru axle') 
        );
    }
  
 }
 
 /**
 * axisRearModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 class axisRearModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
           new axisRearModel(0,'135x5 mm szybkozamykacz'),
           new axisRearModel(1,'135x10 mm thru bolt'),
           new axisRearModel(2,'142x12 thru axle'),
           new axisRearModel(3,'148x12 thru axle'),
           new axisRearModel(4,'150x12 thru axle'),
           new axisRearModel(5,'157x12 thru axle'),
           new axisRearModel(6,'190x12 thru axle'),
           new axisRearModel(7,'197x12 thru axle')
        );
    }
 
    private function All_PL()
    {
        return array
        (
           new axisRearModel(0,'135x5 mm szybkozamykacz'),
           new axisRearModel(1,'135x10 mm thru bolt'),
           new axisRearModel(2,'142x12 thru axle'),
           new axisRearModel(3,'148x12 thru axle'),
           new axisRearModel(4,'150x12 thru axle'),
           new axisRearModel(5,'157x12 thru axle'),
           new axisRearModel(6,'190x12 thru axle'),
           new axisRearModel(7,'197x12 thru axle')
        );
    }
  
 }
 
 /**
 * cassetteMTBModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 class cassetteMTBModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
           new cassetteMTBModel(0,'standardowa'),
           new cassetteMTBModel(1,'do kaset sram XD 11/12 biegów') 
        );
    }
 
    private function All_PL()
    {
        return array
        (
           new cassetteMTBModel(0,'135x5 mm szybkozamykacz'),
           new cassetteMTBModel(1,'135x10 mm thru bolt')
        );
    }
  
 }
 
 /**
 * cassetteRoadModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 class cassetteRoadModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
           new cassetteRoadModel(0,'shimano 8/9/10 biegów'),
           new cassetteRoadModel(1,'shimano 11 biegów'),
           new cassetteRoadModel(2,'Campagnolo 10/11 biegów') 
        );
    }
 
    private function All_PL()
    {
        return array
        (
           new cassetteRoadModel(0,'shimano 8/9/10 biegów'),
           new cassetteRoadModel(1,'shimano 11 biegów'),
           new cassetteRoadModel(2,'Campagnolo 10/11 biegów') 
        );
    }
  
 }
 
 /**
 * sealantModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */
 class sealantModel extends Model
 {
    
    public $id;
    public $name;
    
 
    public function __construct($id = 0, $name = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
    
    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function All()
    {
        switch(Session::GetLang())
        {
            case LANG_EN: return $this->All_EN();
            case LANG_PL: return $this->All_PL();
        }
    }
     
    private function All_EN()
    {
        return array
        (
           new sealantModel(0,'tak, proszę o zestaw z zamontowaną taśmą oraz aluminiowymi wentylkami w kolorze czerwonym'),
           new sealantModel(1,'tak, proszę o zestaw z zamontowaną taśmą oraz aluminiowymi wentylkami w kolorze czarnym'),
           new sealantModel(2,'tak, proszę o zestaw z zamontowaną taśmą oraz stalowymi wentylkami w kolorze  srebrnym'),
           new sealantModel(3,'nie potrzebuję zestawu uszczelniającego'),
           new sealantModel(4,'jestem zainteresowany tylko taśmą uszczelniającą/ochronną')
        );
    }
 
    private function All_PL()
    {
        return array
        (
           new sealantModel(0,'tak, proszę o zestaw z zamontowaną taśmą oraz aluminiowymi wentylkami w kolorze czerwonym'),
           new sealantModel(1,'tak, proszę o zestaw z zamontowaną taśmą oraz aluminiowymi wentylkami w kolorze czarnym'),
           new sealantModel(2,'tak, proszę o zestaw z zamontowaną taśmą oraz stalowymi wentylkami w kolorze  srebrnym'),
           new sealantModel(3,'nie potrzebuję zestawu uszczelniającego'),
           new sealantModel(4,'jestem zainteresowany tylko taśmą uszczelniającą/ochronną')
        );
    }
  
 }
 
 
 
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
